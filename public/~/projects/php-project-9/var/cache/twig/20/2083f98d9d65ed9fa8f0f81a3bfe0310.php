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

/* index.twig */
class __TwigTemplate_2eb1e4062c2db7367342bfcee874f78d extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->blocks = [
            'linkMainActive' => [$this, 'block_linkMainActive'],
            'main' => [$this, 'block_main'],
        ];
    }

    protected function doGetParent(array $context)
    {
        // line 1
        return "sections/base.twig";
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 2
        $context["currentPage"] = ["home" => "active"];
        // line 1
        $this->parent = $this->loadTemplate("sections/base.twig", "index.twig", 1);
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 4
    public function block_linkMainActive($context, array $blocks = [])
    {
        $macros = $this->macros;
        echo "active";
    }

    // line 5
    public function block_main($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 6
        echo "    <div class=\"container-lg rounded-3 mt-3\">
        <div class=\"row\">
            <div class=\"col-12 col-md-10 col-lg-8 mx-auto border rounded-3 p-5\">
                <h1 class=\"display-3\">Анализатор страниц</h1>
                <p class=\"lead\">Бесплатно проверяйте сайты на SEO пригодность</p>
                <form class=\"row mb-3\" action=\"/urls\" method=\"post\">
                    <div class=\"col\">
                        <input type=\"text\" required=\"required\" name=\"url[name]\" class=\"form-control form-control-lg mb-3\" placeholder=\"https://www.example.com\">
                            ";
        // line 14
        if (array_key_exists("invalidDataFormMessage", $context)) {
            // line 15
            echo "                                <div class=\"invalid-feedback\">
                                    ";
            // line 16
            echo twig_escape_filter($this->env, ($context["invalidDataFormMessage"] ?? null), "html", null, true);
            echo "
                                </div>
                            ";
        }
        // line 19
        echo "                    </div>
                    <div class=\"col-auto\">
                        <button type=\"submit\" class=\"btn btn-primary  btn-lg  text-uppercase \">Проверить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
";
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName()
    {
        return "index.twig";
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
        return array (  82 => 19,  76 => 16,  73 => 15,  71 => 14,  61 => 6,  57 => 5,  50 => 4,  45 => 1,  43 => 2,  36 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("{% extends \"sections/base.twig\" %}
{% set currentPage = {\"home\": \"active\"} %}

{% block linkMainActive %}active{% endblock %}
{% block main %}
    <div class=\"container-lg rounded-3 mt-3\">
        <div class=\"row\">
            <div class=\"col-12 col-md-10 col-lg-8 mx-auto border rounded-3 p-5\">
                <h1 class=\"display-3\">Анализатор страниц</h1>
                <p class=\"lead\">Бесплатно проверяйте сайты на SEO пригодность</p>
                <form class=\"row mb-3\" action=\"/urls\" method=\"post\">
                    <div class=\"col\">
                        <input type=\"text\" required=\"required\" name=\"url[name]\" class=\"form-control form-control-lg mb-3\" placeholder=\"https://www.example.com\">
                            {% if invalidDataFormMessage is defined %}
                                <div class=\"invalid-feedback\">
                                    {{ invalidDataFormMessage }}
                                </div>
                            {% endif %}
                    </div>
                    <div class=\"col-auto\">
                        <button type=\"submit\" class=\"btn btn-primary  btn-lg  text-uppercase \">Проверить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
{% endblock %}", "index.twig", "/home/u/projects/php-project-9/templates/index.twig");
    }
}
