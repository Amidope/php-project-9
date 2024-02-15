<?php

namespace App;

use function Functional\map;

class Urldb
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
        $this->pdo->prepare('INSERT INTO urls (name) VALUES (?)')->execute([$name]);
    }

    public function getUrl($id)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM urls WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function saveUrlCheck($id): void
    {
        $urlDb = new \App\Urldb();
        $url = $urlDb->getUrl($id);
        $name = $url['name'];

        //! exception if cant connect

        $client = new \GuzzleHttp\Client();
        $res = $client->request('GET', $name);
        $html = $res->getBody()->getContents();
        $statusCode = $res->getStatusCode();

        $document = new \DiDom\Document($html);
        $d = map(['title', 'h1'], fn($tag) => $document->find($tag)?->first()?->text());
//        $d = map(['title', 'h1'], fn($tag) => $document->find($tag)?->first()?->text());
//        .. empty($elements = $document->find($tag)) ? '' : $elements[0]->text());
        $str = 'title';
        $titles = $document->find($str);
        $h1Headers = $document->find('h1');
        $descriptions = optional($document->xpath('//meta[@name="description"]'))
            ->first()
            ->getAttribute('content');

//            empty($elements = $document->xpath('//meta[@name="description"]'))
//            ? ''
//            : $elements[0]->getAttribute('content');

//        $tagContents = map(
//            [$h1Headers, $titles, $descriptions],
//            fn($elements) => empty($elements) ? '' : $elements[0]->text()
//        );
//        dd($description);
//        $dom->loadHTML($html, LIBXML_NOERROR);
//        $document = new \DOMXPath($dom);
//        $title = $document->find('//title');

//
//        $metaNode = $xpath->query('//meta[@name="description"]')->item(0);
//        $description = is_null($metaNode) ? '' : $metaNode->getAttribute('content');

        $this->pdo
            ->prepare(
                'INSERT INTO url_checks (url_id, status_code, h1, title, description)
                VALUES (:url_id, :status_code, :h1, :title, :description)'
            )
            ->execute(
                [
                    'url_id' => $id,
                    'status_code' => $statusCode,
                    'h1' => $tagContents[0],
                    'title' => $tagContents[1],
                    'description' => $tagContents[2]
                ]
            );
    }
//Where highest_cust_id = 1
    public function getAllUrls()
    {
        return $this->pdo
            ->query('SELECT * FROM urls ORDER BY id DESC')
            ->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getLastUrlCheck(int $id)
    {
        $stmt = $this->pdo->prepare(
            'SELECT * FROM url_checks_fake
                WHERE url_id = ?
                ORDER BY created_at DESC
                LIMIT 1
        ');
        $stmt->execute([$id]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function getAllUrlChecks(int $id)
    {
        $stmt = $this->pdo->prepare(
            'SELECT * FROM url_checks
                WHERE url_id = ?
                ORDER BY created_at DESC
        ');
        $stmt->execute([$id]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getAllUrlsWithChek()
    {
        $sql = "";
        return $this->pdo
            ->query(
                'SELECT urls.id AS id,
                urls.name AS name,
                url_checks.created_at AS last_check,
                url_checks.status_code
                FROM urls
                LEFT JOIN (
                    SELECT 
                        url_id, 
                        id, 
                        status_code, 
                        h1, 
                        title, 
                        description, 
                        created_at,
                        ROW_NUMBER() OVER (PARTITION BY url_id ORDER BY created_at DESC) as row_num
                    FROM 
                        url_checks
                ) AS url_checks
                ON 
                    urls.id = url_checks.url_id AND url_checks.row_num = 1'
            )
            ->fetchAll(\PDO::FETCH_ASSOC);
    }
}