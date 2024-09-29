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

/* partials/sidebar.html.twig */
class __TwigTemplate_892ea819dd722c00cc8d87fb5bd49e270ab8330e2030ec14cc2cb40e574f984c extends \Twig\Template
{
    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        // line 25
        echo "
";
        // line 38
        echo "
";
        // line 39
        $context["macro"] = $this;
        // line 40
        echo "
<div class=\"scrollbar-inner\">
    <div class=\"highlightable\">
        ";
        // line 43
        if ($this->getAttribute(($context["theme_config"] ?? null), "top_level_version", [])) {
            // line 44
            echo "            ";
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable($this->getAttribute(($context["pages"] ?? null), "children", []));
            foreach ($context['_seq'] as $context["slug"] => $context["ver"]) {
                // line 45
                echo "                ";
                echo $context["macro"]->getversion($context["ver"]);
                echo "
                <ul id=\"";
                // line 46
                echo twig_escape_filter($this->env, $context["slug"], "html", null, true);
                echo "\" class=\"topics\">
                ";
                // line 47
                echo $context["macro"]->getloop($context["ver"], "");
                echo "
                </ul>
            ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['slug'], $context['ver'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 50
            echo "        ";
        } else {
            // line 51
            echo "            <ul class=\"topics\">
                ";
            // line 52
            if ($this->getAttribute(($context["theme_config"] ?? null), "root_page", [])) {
                // line 53
                echo "                    ";
                echo $context["macro"]->getloop($this->getAttribute(($context["page"] ?? null), "find", [0 => $this->getAttribute(($context["theme_config"] ?? null), "root_page", [])], "method"), "");
                echo "
                ";
            } else {
                // line 55
                echo "            ";
                echo $context["macro"]->getloop(($context["pages"] ?? null), "");
                echo "
                ";
            }
            // line 57
            echo "            </ul>
        ";
        }
        // line 59
        echo "        <hr />

        <a class=\"padding\" href=\"#\" data-clear-history-toggle><i
                    class=\"fa fa-fw fa-history\"></i> ";
        // line 62
        echo twig_escape_filter($this->env, $this->env->getExtension('Grav\Common\Twig\Extension\GravExtension')->translate($this->env, "THEME_LEARN2_CLEAR_HISTORY"), "html", null, true);
        echo "</a><br/>

        <section id=\"footer\">
            <p>";
        // line 65
        echo $this->env->getExtension('Grav\Common\Twig\Extension\GravExtension')->translate($this->env, "THEME_LEARN2_BUILT_WITH_GRAV");
        echo "</p>
        </section>
    </div>
</div>
";
    }

    // line 1
    public function getloop($__page__ = null, $__parent_loop__ = null, ...$__varargs__)
    {
        $context = $this->env->mergeGlobals([
            "page" => $__page__,
            "parent_loop" => $__parent_loop__,
            "varargs" => $__varargs__,
        ]);

        $blocks = [];

        ob_start();
        try {
            // line 2
            echo "    ";
            $context["self"] = $this;
            // line 3
            echo "
    ";
            // line 4
            if ((twig_length_filter($this->env, ($context["parent_loop"] ?? null)) > 0)) {
                // line 5
                echo "        ";
                $context["data_level"] = ($context["parent_loop"] ?? null);
                // line 6
                echo "    ";
            } else {
                // line 7
                echo "        ";
                $context["data_level"] = 0;
                // line 8
                echo "    ";
            }
            // line 9
            echo "    ";
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable($this->getAttribute($this->getAttribute(($context["page"] ?? null), "children", []), "visible", []));
            $context['loop'] = [
              'parent' => $context['_parent'],
              'index0' => 0,
              'index'  => 1,
              'first'  => true,
            ];
            if (is_array($context['_seq']) || (is_object($context['_seq']) && $context['_seq'] instanceof \Countable)) {
                $length = count($context['_seq']);
                $context['loop']['revindex0'] = $length - 1;
                $context['loop']['revindex'] = $length;
                $context['loop']['length'] = $length;
                $context['loop']['last'] = 1 === $length;
            }
            foreach ($context['_seq'] as $context["_key"] => $context["p"]) {
                // line 10
                echo "        ";
                $context["parent_page"] = (($this->getAttribute($context["p"], "activeChild", [])) ? (" parent") : (""));
                // line 11
                echo "        ";
                $context["current_page"] = (($this->getAttribute($context["p"], "active", [])) ? (" active") : (""));
                // line 12
                echo "        <li class=\"dd-item";
                echo twig_escape_filter($this->env, ($context["parent_page"] ?? null), "html", null, true);
                echo twig_escape_filter($this->env, ($context["current_page"] ?? null), "html", null, true);
                echo "\" data-nav-id=\"";
                echo twig_escape_filter($this->env, $this->getAttribute($context["p"], "route", []), "html", null, true);
                echo "\">
            <a href=\"";
                // line 13
                echo twig_escape_filter($this->env, $this->getAttribute($context["p"], "url", []), "html", null, true);
                echo "\" ";
                if ($this->getAttribute($this->getAttribute($context["p"], "header", []), "class", [])) {
                    echo "class=\"";
                    echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context["p"], "header", []), "class", []), "html", null, true);
                    echo "\"";
                }
                echo ">
                <i class=\"fa fa-check read-icon\"></i>
                <span><b>";
                // line 15
                if ((($context["data_level"] ?? null) == 0)) {
                    echo twig_escape_filter($this->env, $this->getAttribute($context["loop"], "index", []), "html", null, true);
                    echo ". ";
                }
                echo "</b>";
                echo twig_escape_filter($this->env, $this->getAttribute($context["p"], "menu", []), "html", null, true);
                echo "</span>
            </a>
            ";
                // line 17
                if (($this->getAttribute($this->getAttribute($context["p"], "children", []), "count", []) > 0)) {
                    // line 18
                    echo "            <ul>
                ";
                    // line 19
                    echo $context["self"]->getloop($context["p"], (((array_key_exists("parent_loop", $context)) ? (_twig_default_filter(($context["parent_loop"] ?? null), 0)) : (0)) + $this->getAttribute($context["loop"], "index", [])));
                    echo "
            </ul>
            ";
                }
                // line 22
                echo "        </li>
    ";
                ++$context['loop']['index0'];
                ++$context['loop']['index'];
                $context['loop']['first'] = false;
                if (isset($context['loop']['length'])) {
                    --$context['loop']['revindex0'];
                    --$context['loop']['revindex'];
                    $context['loop']['last'] = 0 === $context['loop']['revindex0'];
                }
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['p'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
        } catch (\Exception $e) {
            ob_end_clean();

            throw $e;
        } catch (\Throwable $e) {
            ob_end_clean();

            throw $e;
        }

        return ('' === $tmp = ob_get_clean()) ? '' : new Markup($tmp, $this->env->getCharset());
    }

    // line 26
    public function getversion($__p__ = null, ...$__varargs__)
    {
        $context = $this->env->mergeGlobals([
            "p" => $__p__,
            "varargs" => $__varargs__,
        ]);

        $blocks = [];

        ob_start();
        try {
            // line 27
            echo "    ";
            $context["parent_page"] = (($this->getAttribute(($context["p"] ?? null), "activeChild", [])) ? (" parent") : (""));
            // line 28
            echo "    ";
            $context["current_page"] = (($this->getAttribute(($context["p"] ?? null), "active", [])) ? (" active") : (""));
            // line 29
            echo "    <h5 class=\"";
            echo twig_escape_filter($this->env, ($context["parent_page"] ?? null), "html", null, true);
            echo twig_escape_filter($this->env, ($context["current_page"] ?? null), "html", null, true);
            echo "\">
        ";
            // line 30
            if (($this->getAttribute(($context["p"] ?? null), "activeChild", []) || $this->getAttribute(($context["p"] ?? null), "active", []))) {
                // line 31
                echo "        <i class=\"fa fa-chevron-down fa-fw\"></i>
        ";
            } else {
                // line 33
                echo "        <i class=\"fa fa-plus fa-fw\"></i>
        ";
            }
            // line 35
            echo "        <a href=\"";
            echo twig_escape_filter($this->env, $this->getAttribute(($context["p"] ?? null), "url", []), "html", null, true);
            echo "\">";
            echo twig_escape_filter($this->env, $this->getAttribute(($context["p"] ?? null), "menu", []), "html", null, true);
            echo "</a>
    </h5>
";
        } catch (\Exception $e) {
            ob_end_clean();

            throw $e;
        } catch (\Throwable $e) {
            ob_end_clean();

            throw $e;
        }

        return ('' === $tmp = ob_get_clean()) ? '' : new Markup($tmp, $this->env->getCharset());
    }

    public function getTemplateName()
    {
        return "partials/sidebar.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  271 => 35,  267 => 33,  263 => 31,  261 => 30,  255 => 29,  252 => 28,  249 => 27,  237 => 26,  209 => 22,  203 => 19,  200 => 18,  198 => 17,  188 => 15,  177 => 13,  169 => 12,  166 => 11,  163 => 10,  145 => 9,  142 => 8,  139 => 7,  136 => 6,  133 => 5,  131 => 4,  128 => 3,  125 => 2,  112 => 1,  103 => 65,  97 => 62,  92 => 59,  88 => 57,  82 => 55,  76 => 53,  74 => 52,  71 => 51,  68 => 50,  59 => 47,  55 => 46,  50 => 45,  45 => 44,  43 => 43,  38 => 40,  36 => 39,  33 => 38,  30 => 25,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("{% macro loop(page, parent_loop) %}
    {% import _self as self %}

    {% if parent_loop|length > 0 %}
        {% set data_level = parent_loop %}
    {% else %}
        {% set data_level = 0 %}
    {% endif %}
    {% for p in page.children.visible %}
        {% set parent_page = p.activeChild ? ' parent' : '' %}
        {% set current_page = p.active ? ' active' : '' %}
        <li class=\"dd-item{{ parent_page }}{{ current_page }}\" data-nav-id=\"{{ p.route }}\">
            <a href=\"{{ p.url }}\" {% if p.header.class %}class=\"{{ p.header.class }}\"{% endif %}>
                <i class=\"fa fa-check read-icon\"></i>
                <span><b>{% if data_level == 0 %}{{ loop.index }}. {% endif %}</b>{{ p.menu }}</span>
            </a>
            {% if p.children.count > 0 %}
            <ul>
                {{ self.loop(p, parent_loop|default(0)+loop.index) }}
            </ul>
            {% endif %}
        </li>
    {% endfor %}
{% endmacro %}

{% macro version(p) %}
    {% set parent_page = p.activeChild ? ' parent' : '' %}
    {% set current_page = p.active ? ' active' : '' %}
    <h5 class=\"{{ parent_page }}{{ current_page }}\">
        {% if p.activeChild or p.active %}
        <i class=\"fa fa-chevron-down fa-fw\"></i>
        {% else %}
        <i class=\"fa fa-plus fa-fw\"></i>
        {% endif %}
        <a href=\"{{ p.url }}\">{{ p.menu }}</a>
    </h5>
{% endmacro %}

{% import _self as macro %}

<div class=\"scrollbar-inner\">
    <div class=\"highlightable\">
        {% if theme_config.top_level_version %}
            {% for slug, ver in pages.children %}
                {{ macro.version(ver) }}
                <ul id=\"{{ slug }}\" class=\"topics\">
                {{ macro.loop(ver, '') }}
                </ul>
            {% endfor %}
        {% else %}
            <ul class=\"topics\">
                {% if theme_config.root_page %}
                    {{ macro.loop(page.find(theme_config.root_page), '') }}
                {% else %}
            {{ macro.loop(pages, '') }}
                {% endif %}
            </ul>
        {% endif %}
        <hr />

        <a class=\"padding\" href=\"#\" data-clear-history-toggle><i
                    class=\"fa fa-fw fa-history\"></i> {{ 'THEME_LEARN2_CLEAR_HISTORY'|t }}</a><br/>

        <section id=\"footer\">
            <p>{{ 'THEME_LEARN2_BUILT_WITH_GRAV'|t|raw }}</p>
        </section>
    </div>
</div>
", "partials/sidebar.html.twig", "C:\\httpd\\htdocs\\esppo-smabat\\panduan-esppo\\user\\themes\\learn2\\templates\\partials\\sidebar.html.twig");
    }
}
