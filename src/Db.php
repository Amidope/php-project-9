<?php

namespace Amidope\PageAnalyzer;

use Carbon\Carbon;
use DiDom\Query;

use function Functional\map;

class Db
{
    private \PDO $pdo;
    public function __construct()
    {
        $this->pdo = Connection::get()->connect();
    }

    public function getUrlIdByName(string $name): false|int
    {
        $stmt = $this->pdo->prepare('SELECT id FROM urls WHERE name = ?');
        $stmt->execute([$name]);
        return $stmt->fetchColumn();
    }

    public function saveUrl(string $name): void
    {
        $this->pdo
            ->prepare('INSERT INTO urls (name, created_at) VALUES (:name, :created_at)')
            ->execute([
                'name' => $name,
                'created_at' => Carbon::now()
            ]);
    }

    public function getUrl(int $id)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM urls WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function saveUrlCheck(int $id): void
    {
        $url = $this->getUrl($id);
        $name = $url['name'];

        $client = new \GuzzleHttp\Client();
        $res = $client->request('GET', $name);

        /** @var string $html */
        $html = $res->getBody()->getContents();
        $statusCode = $res->getStatusCode();

        $document = new \DiDom\Document($html);
        $tagContents = map(
            ['h1' => 'h1', 'title' => 'title'],
            function ($tag) use ($document) {
                /** @var \DiDom\Element|null $node */
                $node = $document->first($tag, $type = Query::TYPE_CSS, true);
                return $node->text();
            }
            //            fn($tag) => $document->first($tag)?->text()
        );

        $description = $document->first('meta[name="description"]')
            ?->getAttribute('content');

        $this->pdo
            ->prepare(
                'INSERT INTO url_checks (url_id, status_code, h1, title, description, created_at)
                VALUES (:url_id, :status_code, :h1, :title, :description, :created_at)'
            )
            ->execute(
                [
                    'url_id' => $id,
                    'status_code' => $statusCode,
                    'description' => $description,
                    'created_at' => Carbon::now(),
                    ...$tagContents
                ]
            );
    }

    public function getAllUrlChecks(int $id)
    {
        $stmt = $this->pdo->prepare(
            'SELECT * FROM url_checks
                WHERE url_id = ?
                ORDER BY created_at DESC
        '
        );
        $stmt->execute([$id]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getAllUrlsWithChek()
    {
        $sql = '';
        return $this->pdo
            ->query(
                'SELECT urls.id AS id,
                urls.name AS name,
                url_checks.created_at AS last_check,
                url_checks.status_code
                FROM urls
                LEFT JOIN (
                    SELECT 
                        *,
                        ROW_NUMBER() OVER (PARTITION BY url_id ORDER BY created_at DESC) as row_num
                    FROM 
                        url_checks
                ) AS url_checks
                ON urls.id = url_checks.url_id AND url_checks.row_num = 1'
            )
            ->fetchAll(\PDO::FETCH_ASSOC);
    }
}
