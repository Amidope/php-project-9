<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* sections/base.twig */
class __TwigTemplate_c8959fc946186007d1ccb5fba5f87983 extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
            'main' => [$this, 'block_main'],
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 1
        echo "<!doctype html>
<html lang=\"ru\">
<head>
    <meta charset=\"UTF-8\">
    <meta name=\"viewport\"
          content=\"width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0\">
    <meta http-equiv=\"X-UA-Compatible\" content=\"ie=edge\">
    <link href=\"https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css\" rel=\"stylesheet\" integrity=\"sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN\" crossorigin=\"anonymous\">
    <title>Page analyzer</title>
</head>
<body>
    <header>
        <nav class=\"navbar navbar-expand-sm bg-dark px-3\" data-bs-theme=\"dark\">
            <a class=\"navbar-brand px-0\" href=\"/\">Анализатор страниц</a>
            <button class=\"navbar-toggler\" type=\"button\" data-toggle=\"collapse\" data-target=\"#navbarNav\" aria-controls=\"navbarNav\" aria-expanded=\"false\" aria-label=\"Toggle navigation\">
                <span class=\"navbar-toggler-icon\"></span>
            </button>
            <div class=\"collapse navbar-collapse\" id=\"navbarSupportedContent\">
                <ul class=\"navbar-nav\">
                    <li class=\"nav-item\">
                        <a class=\"nav-link ";
        // line 21
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["currentPage"] ?? null), "home", [], "any", false, false, false, 21), "html", null, true);
        echo "\" aria-current=\"page\" href=\"/\">Главная</a>
                    </li>
                    <li class=\"nav-item\">
                        <a class=\"nav-link ";
        // line 24
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["currentPage"] ?? null), "urls", [], "any", false, false, false, 24), "html", null, true);
        echo "\" href=\"/urls\">Сайты</a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <main>
        ";
        // line 31
        $this->displayBlock('main', $context, $blocks);
        // line 32
        echo "    </main>
</body>
</html>";
    }

    // line 31
    public function block_main($context, array $blocks = [])
    {
        $macros = $this->macros;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName()
    {
        return "sections/base.twig";
    }

    /**
     * @codeCoverageIgnore
     */
    public function isTraitable()
    {
        return false;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getDebugInfo()
    {
        return array (  84 => 31,  78 => 32,  76 => 31,  66 => 24,  60 => 21,  38 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("<!doctype html>
<html lang=\"ru\">
<head>
    <meta charset=\"UTF-8\">
    <meta name=\"viewport\"
          content=\"width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0\">
    <meta http-equiv=\"X-UA-Compatible\" content=\"ie=edge\">
    <link href=\"https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css\" rel=\"stylesheet\" integrity=\"sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN\" crossorigin=\"anonymous\">
    <title>Page analyzer</title>
</head>
<body>
    <header>
        <nav class=\"navbar navbar-expand-sm bg-dark px-3\" data-bs-theme=\"dark\">
            <a class=\"navbar-brand px-0\" href=\"/\">Анализатор страниц</a>
            <button class=\"navbar-toggler\" type=\"button\" data-toggle=\"collapse\" data-target=\"#navbarNav\" aria-controls=\"navbarNav\" aria-expanded=\"false\" aria-label=\"Toggle navigation\">
                <span class=\"navbar-toggler-icon\"></span>
            </button>
            <div class=\"collapse navbar-collapse\" id=\"navbarSupportedContent\">
                <ul class=\"navbar-nav\">
                    <li class=\"nav-item\">
                        <a class=\"nav-link {{ currentPage.home }}\" aria-current=\"page\" href=\"/\">Главная</a>
                    </li>
                    <li class=\"nav-item\">
                        <a class=\"nav-link {{ currentPage.urls }}\" href=\"/urls\">Сайты</a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <main>
        {% block main %}{% endblock %}
    </main>
</body>
</html>", "sections/base.twig", "/home/u/projects/php-project-9/templates/sections/base.twig");
    }
}
