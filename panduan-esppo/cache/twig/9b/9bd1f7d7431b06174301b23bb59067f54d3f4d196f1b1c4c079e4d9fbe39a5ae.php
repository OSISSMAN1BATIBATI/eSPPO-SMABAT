<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* partials/base.html.twig */
class __TwigTemplate_230359ae25cf3b89f8a6cc9460fa0ab62541f41fe6beb68a646520e6478ea4de extends \Twig\Template
{
    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = [
            'head' => [$this, 'block_head'],
            'stylesheets' => [$this, 'block_stylesheets'],
            'javascripts' => [$this, 'block_javascripts'],
            'assets' => [$this, 'block_assets'],
            'sidebar' => [$this, 'block_sidebar'],
            'body' => [$this, 'block_body'],
            'topbar' => [$this, 'block_topbar'],
            'content' => [$this, 'block_content'],
            'footer' => [$this, 'block_footer'],
            'navigation' => [$this, 'block_navigation'],
            'analytics' => [$this, 'block_analytics'],
            'bottom' => [$this, 'block_bottom'],
        ];
        $this->deferred = $this->env->getExtension('Twig\DeferredExtension\DeferredExtension');
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        // line 1
        $context["theme_config"] = $this->getAttribute($this->getAttribute(($context["config"] ?? null), "themes", []), $this->getAttribute($this->getAttribute($this->getAttribute(($context["config"] ?? null), "system", []), "pages", []), "theme", []));
        // line 2
        $context["github_link_position"] = ((array_key_exists("github_link_position", $context)) ? (($context["github_link_position"] ?? null)) : ($this->getAttribute($this->getAttribute(($context["theme_config"] ?? null), "github", []), "position", [])));
        // line 3
        echo "<!DOCTYPE html>
<html lang=\"";
        // line 4
        echo twig_escape_filter($this->env, (($this->getAttribute($this->getAttribute(($context["grav"] ?? null), "language", []), "getActive", [])) ? ($this->getAttribute($this->getAttribute(($context["grav"] ?? null), "language", []), "getActive", [])) : ($this->getAttribute($this->getAttribute($this->getAttribute(($context["grav"] ?? null), "config", []), "site", []), "default_lang", []))), "html", null, true);
        echo "\">
<head>
";
        // line 6
        $this->displayBlock('head', $context, $blocks);
        // line 44
        echo "</head>
<body class=\"searchbox-hidden ";
        // line 45
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["page"] ?? null), "header", []), "body_classes", []), "html", null, true);
        echo "\" data-url=\"";
        echo twig_escape_filter($this->env, $this->getAttribute(($context["page"] ?? null), "route", []), "html", null, true);
        echo "\">
    ";
        // line 46
        $this->displayBlock('sidebar', $context, $blocks);
        // line 57
        echo "
    ";
        // line 58
        $this->displayBlock('body', $context, $blocks);
        // line 91
        echo "
    ";
        // line 92
        $this->displayBlock('analytics', $context, $blocks);
        // line 97
        echo "
    ";
        // line 98
        $this->displayBlock('bottom', $context, $blocks);
        // line 101
        echo " </body>
</html>
";
        $this->deferred->resolve($this, $context, $blocks);
    }

    // line 6
    public function block_head($context, array $blocks = [])
    {
        // line 7
        echo "    <meta charset=\"utf-8\" />
    <title>";
        // line 8
        if ($this->getAttribute(($context["header"] ?? null), "title", [])) {
            echo twig_escape_filter($this->env, $this->getAttribute(($context["header"] ?? null), "title", []), "html", null, true);
            echo " | ";
        }
        echo twig_escape_filter($this->env, $this->getAttribute(($context["site"] ?? null), "title", []), "html", null, true);
        echo "</title>
    ";
        // line 9
        $this->loadTemplate("partials/metadata.html.twig", "partials/base.html.twig", 9)->display($context);
        // line 10
        echo "    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no\" />
    <link rel=\"alternate\" type=\"application/atom+xml\" href=\"";
        // line 11
        echo twig_escape_filter($this->env, ($context["base_url_absolute"] ?? null), "html", null, true);
        echo "/feed:atom\" title=\"Atom Feed\" />
    <link rel=\"alternate\" type=\"application/rss+xml\" href=\"";
        // line 12
        echo twig_escape_filter($this->env, ($context["base_url_absolute"] ?? null), "html", null, true);
        echo "/feed:rss\" title=\"RSS Feed\" />
    <link rel=\"icon\" type=\"image/png\" href=\"";
        // line 13
        echo twig_escape_filter($this->env, $this->env->getExtension('Grav\Common\Twig\Extension\GravExtension')->urlFunc("theme://images/favicon.png"), "html", null, true);
        echo "\">

    ";
        // line 15
        $this->displayBlock('stylesheets', $context, $blocks);
        // line 28
        echo "
    ";
        // line 29
        $this->displayBlock('javascripts', $context, $blocks);
        // line 37
        echo "
    ";
        // line 38
        $this->displayBlock('assets', $context, $blocks);
        // line 42
        echo "
";
    }

    // line 15
    public function block_stylesheets($context, array $blocks = [])
    {
        // line 16
        echo "        ";
        $this->getAttribute(($context["assets"] ?? null), "addCss", [0 => "theme://css-compiled/nucleus.css", 1 => 102], "method");
        // line 17
        echo "        ";
        $this->getAttribute(($context["assets"] ?? null), "addCss", [0 => "theme://css-compiled/theme.css", 1 => 101], "method");
        // line 18
        echo "        ";
        $this->getAttribute(($context["assets"] ?? null), "addCss", [0 => "theme://css/custom.css", 1 => 100], "method");
        // line 19
        echo "        ";
        $this->getAttribute(($context["assets"] ?? null), "addCss", [0 => "theme://css/font-awesome.min.css", 1 => 100], "method");
        // line 20
        echo "        ";
        $this->getAttribute(($context["assets"] ?? null), "addCss", [0 => "theme://css/featherlight.min.css"], "method");
        // line 21
        echo "
        ";
        // line 22
        if (((($this->getAttribute(($context["browser"] ?? null), "getBrowser", []) == "msie") && ($this->getAttribute(($context["browser"] ?? null), "getVersion", []) >= 8)) && ($this->getAttribute(($context["browser"] ?? null), "getVersion", []) <= 9))) {
            // line 23
            echo "            ";
            $this->getAttribute(($context["assets"] ?? null), "addCss", [0 => "theme://css/nucleus-ie9.css"], "method");
            // line 24
            echo "            ";
            $this->getAttribute(($context["assets"] ?? null), "addCss", [0 => "theme://css/pure-0.5.0/grids-min.css"], "method");
            // line 25
            echo "            ";
            $this->getAttribute(($context["assets"] ?? null), "addJs", [0 => "theme://js/html5shiv-printshiv.min.js"], "method");
            // line 26
            echo "        ";
        }
        // line 27
        echo "    ";
    }

    // line 29
    public function block_javascripts($context, array $blocks = [])
    {
        // line 30
        echo "        ";
        $this->getAttribute(($context["assets"] ?? null), "addJs", [0 => "jquery", 1 => 101], "method");
        // line 31
        echo "        ";
        $this->getAttribute(($context["assets"] ?? null), "addJs", [0 => "theme://js/modernizr.custom.71422.js", 1 => 100], "method");
        // line 32
        echo "        ";
        $this->getAttribute(($context["assets"] ?? null), "addJs", [0 => "theme://js/featherlight.min.js"], "method");
        // line 33
        echo "        ";
        $this->getAttribute(($context["assets"] ?? null), "addJs", [0 => "theme://js/clipboard.min.js"], "method");
        // line 34
        echo "        ";
        $this->getAttribute(($context["assets"] ?? null), "addJs", [0 => "theme://js/jquery.scrollbar.min.js"], "method");
        // line 35
        echo "        ";
        $this->getAttribute(($context["assets"] ?? null), "addJs", [0 => "theme://js/learn.js"], "method");
        // line 36
        echo "    ";
    }

    public function block_assets($context, array $blocks = [])
    {
        $this->deferred->defer($this, 'assets');
    }

    // line 38
    public function block_assets_deferred($context, array $blocks = [])
    {
        // line 39
        echo "    ";
        echo $this->getAttribute(($context["assets"] ?? null), "css", [], "method");
        echo "
    ";
        // line 40
        echo $this->getAttribute(($context["assets"] ?? null), "js", [], "method");
        echo "
  ";
        $this->deferred->resolve($this, $context, $blocks);
    }

    // line 46
    public function block_sidebar($context, array $blocks = [])
    {
        // line 47
        echo "    <nav id=\"sidebar\">
        <div id=\"header-wrapper\">
            <div id=\"header\">
                <a id=\"logo\" href=\"";
        // line 50
        echo twig_escape_filter($this->env, (($this->getAttribute(($context["theme_config"] ?? null), "home_url", [])) ? ($this->getAttribute(($context["theme_config"] ?? null), "home_url", [])) : (($context["base_url_absolute"] ?? null))), "html", null, true);
        echo "\">";
        $this->loadTemplate("partials/logo.html.twig", "partials/base.html.twig", 50)->display($context);
        echo "</a>
                ";
        // line 51
        $this->loadTemplate("partials/search.html.twig", "partials/base.html.twig", 51)->display($context);
        // line 52
        echo "            </div>
        </div>
        ";
        // line 54
        $this->loadTemplate("partials/sidebar.html.twig", "partials/base.html.twig", 54)->display($context);
        // line 55
        echo "    </nav>
    ";
    }

    // line 58
    public function block_body($context, array $blocks = [])
    {
        // line 59
        echo "    <section id=\"body\">
        <div id=\"overlay\"></div>

        <div class=\"padding highlightable\">
            <a href=\"#\" id=\"sidebar-toggle\" data-sidebar-toggle><i class=\"fa fa-2x fa-bars\"></i></a>

            ";
        // line 65
        $this->displayBlock('topbar', $context, $blocks);
        // line 78
        echo "
            ";
        // line 79
        $this->displayBlock('content', $context, $blocks);
        // line 80
        echo "
            ";
        // line 81
        $this->displayBlock('footer', $context, $blocks);
        // line 86
        echo "
        </div>
        ";
        // line 88
        $this->displayBlock('navigation', $context, $blocks);
        // line 89
        echo "    </section>
    ";
    }

    // line 65
    public function block_topbar($context, array $blocks = [])
    {
        if (((($context["github_link_position"] ?? null) == "top") || $this->getAttribute($this->getAttribute($this->getAttribute(($context["config"] ?? null), "plugins", []), "breadcrumbs", []), "enabled", []))) {
            // line 66
            echo "            <div id=\"top-bar\">
                ";
            // line 67
            if ((($context["github_link_position"] ?? null) == "top")) {
                // line 68
                echo "                <div id=\"top-github-link\">
                ";
                // line 69
                $this->loadTemplate("partials/github_link.html.twig", "partials/base.html.twig", 69)->display($context);
                // line 70
                echo "                </div>
                ";
            }
            // line 72
            echo "
                ";
            // line 73
            if ($this->getAttribute($this->getAttribute($this->getAttribute(($context["config"] ?? null), "plugins", []), "breadcrumbs", []), "enabled", [])) {
                // line 74
                echo "                ";
                $this->loadTemplate("partials/breadcrumbs.html.twig", "partials/base.html.twig", 74)->display($context);
                // line 75
                echo "                ";
            }
            // line 76
            echo "            </div>
            ";
        }
    }

    // line 79
    public function block_content($context, array $blocks = [])
    {
    }

    // line 81
    public function block_footer($context, array $blocks = [])
    {
        // line 82
        echo "                ";
        if ((($context["github_link_position"] ?? null) == "bottom")) {
            // line 83
            echo "                ";
            $this->loadTemplate("partials/github_note.html.twig", "partials/base.html.twig", 83)->display($context);
            // line 84
            echo "                ";
        }
        // line 85
        echo "            ";
    }

    // line 88
    public function block_navigation($context, array $blocks = [])
    {
    }

    // line 92
    public function block_analytics($context, array $blocks = [])
    {
        // line 93
        echo "        ";
        if ($this->getAttribute(($context["theme_config"] ?? null), "google_analytics_code", [])) {
            // line 94
            echo "        ";
            $this->loadTemplate("partials/analytics.html.twig", "partials/base.html.twig", 94)->display($context);
            // line 95
            echo "        ";
        }
        // line 96
        echo "    ";
    }

    // line 98
    public function block_bottom($context, array $blocks = [])
    {
        // line 99
        echo "        ";
        echo $this->getAttribute(($context["assets"] ?? null), "js", [0 => "bottom"], "method");
        echo "
    ";
    }

    public function getTemplateName()
    {
        return "partials/base.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  364 => 99,  361 => 98,  357 => 96,  354 => 95,  351 => 94,  348 => 93,  345 => 92,  340 => 88,  336 => 85,  333 => 84,  330 => 83,  327 => 82,  324 => 81,  319 => 79,  313 => 76,  310 => 75,  307 => 74,  305 => 73,  302 => 72,  298 => 70,  296 => 69,  293 => 68,  291 => 67,  288 => 66,  284 => 65,  279 => 89,  277 => 88,  273 => 86,  271 => 81,  268 => 80,  266 => 79,  263 => 78,  261 => 65,  253 => 59,  250 => 58,  245 => 55,  243 => 54,  239 => 52,  237 => 51,  231 => 50,  226 => 47,  223 => 46,  216 => 40,  211 => 39,  208 => 38,  199 => 36,  196 => 35,  193 => 34,  190 => 33,  187 => 32,  184 => 31,  181 => 30,  178 => 29,  174 => 27,  171 => 26,  168 => 25,  165 => 24,  162 => 23,  160 => 22,  157 => 21,  154 => 20,  151 => 19,  148 => 18,  145 => 17,  142 => 16,  139 => 15,  134 => 42,  132 => 38,  129 => 37,  127 => 29,  124 => 28,  122 => 15,  117 => 13,  113 => 12,  109 => 11,  106 => 10,  104 => 9,  96 => 8,  93 => 7,  90 => 6,  83 => 101,  81 => 98,  78 => 97,  76 => 92,  73 => 91,  71 => 58,  68 => 57,  66 => 46,  60 => 45,  57 => 44,  55 => 6,  50 => 4,  47 => 3,  45 => 2,  43 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("{% set theme_config = attribute(config.themes, config.system.pages.theme) %}
{% set github_link_position = github_link_position is defined ? github_link_position : theme_config.github.position %}
<!DOCTYPE html>
<html lang=\"{{ grav.language.getActive ?: grav.config.site.default_lang }}\">
<head>
{% block head %}
    <meta charset=\"utf-8\" />
    <title>{% if header.title %}{{ header.title }} | {% endif %}{{ site.title }}</title>
    {% include 'partials/metadata.html.twig' %}
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no\" />
    <link rel=\"alternate\" type=\"application/atom+xml\" href=\"{{ base_url_absolute}}/feed:atom\" title=\"Atom Feed\" />
    <link rel=\"alternate\" type=\"application/rss+xml\" href=\"{{ base_url_absolute}}/feed:rss\" title=\"RSS Feed\" />
    <link rel=\"icon\" type=\"image/png\" href=\"{{ url('theme://images/favicon.png') }}\">

    {% block stylesheets %}
        {% do assets.addCss('theme://css-compiled/nucleus.css',102) %}
        {% do assets.addCss('theme://css-compiled/theme.css',101) %}
        {% do assets.addCss('theme://css/custom.css',100) %}
        {% do assets.addCss('theme://css/font-awesome.min.css',100) %}
        {% do assets.addCss('theme://css/featherlight.min.css') %}

        {% if browser.getBrowser == 'msie' and browser.getVersion >= 8 and browser.getVersion <= 9 %}
            {% do assets.addCss('theme://css/nucleus-ie9.css') %}
            {% do assets.addCss('theme://css/pure-0.5.0/grids-min.css') %}
            {% do assets.addJs('theme://js/html5shiv-printshiv.min.js') %}
        {% endif %}
    {% endblock %}

    {% block javascripts %}
        {% do assets.addJs('jquery',101) %}
        {% do assets.addJs('theme://js/modernizr.custom.71422.js',100) %}
        {% do assets.addJs('theme://js/featherlight.min.js') %}
        {% do assets.addJs('theme://js/clipboard.min.js') %}
        {% do assets.addJs('theme://js/jquery.scrollbar.min.js') %}
        {% do assets.addJs('theme://js/learn.js') %}
    {% endblock %}

    {% block assets deferred %}
    {{ assets.css()|raw }}
    {{ assets.js()|raw }}
  {% endblock %}

{% endblock head %}
</head>
<body class=\"searchbox-hidden {{ page.header.body_classes }}\" data-url=\"{{ page.route }}\">
    {% block sidebar %}
    <nav id=\"sidebar\">
        <div id=\"header-wrapper\">
            <div id=\"header\">
                <a id=\"logo\" href=\"{{ theme_config.home_url ?: base_url_absolute }}\">{% include 'partials/logo.html.twig' %}</a>
                {% include 'partials/search.html.twig' %}
            </div>
        </div>
        {% include 'partials/sidebar.html.twig' %}
    </nav>
    {% endblock %}

    {% block body %}
    <section id=\"body\">
        <div id=\"overlay\"></div>

        <div class=\"padding highlightable\">
            <a href=\"#\" id=\"sidebar-toggle\" data-sidebar-toggle><i class=\"fa fa-2x fa-bars\"></i></a>

            {% block topbar %}{% if  github_link_position == 'top' or config.plugins.breadcrumbs.enabled %}
            <div id=\"top-bar\">
                {% if  github_link_position == 'top' %}
                <div id=\"top-github-link\">
                {% include 'partials/github_link.html.twig' %}
                </div>
                {% endif %}

                {% if config.plugins.breadcrumbs.enabled %}
                {% include 'partials/breadcrumbs.html.twig' %}
                {% endif %}
            </div>
            {% endif %}{% endblock %}

            {% block content %}{% endblock %}

            {% block footer %}
                {% if  github_link_position == 'bottom' %}
                {% include 'partials/github_note.html.twig' %}
                {% endif %}
            {% endblock %}

        </div>
        {% block navigation %}{% endblock %}
    </section>
    {% endblock %}

    {% block analytics %}
        {% if theme_config.google_analytics_code %}
        {% include 'partials/analytics.html.twig' %}
        {% endif %}
    {% endblock %}

    {% block bottom %}
        {{ assets.js('bottom')|raw }}
    {% endblock %}
 </body>
</html>
", "partials/base.html.twig", "C:\\httpd\\htdocs\\esppo-smabat\\panduan-esppo\\user\\themes\\learn2\\templates\\partials\\base.html.twig");
    }
    private $deferred;
}
