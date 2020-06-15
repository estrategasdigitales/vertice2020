<?php

namespace WPML\Core;

use \WPML\Core\Twig\Environment;
use \WPML\Core\Twig\Error\LoaderError;
use \WPML\Core\Twig\Error\RuntimeError;
use \WPML\Core\Twig\Markup;
use \WPML\Core\Twig\Sandbox\SecurityError;
use \WPML\Core\Twig\Sandbox\SecurityNotAllowedTagError;
use \WPML\Core\Twig\Sandbox\SecurityNotAllowedFilterError;
use \WPML\Core\Twig\Sandbox\SecurityNotAllowedFunctionError;
use \WPML\Core\Twig\Source;
use \WPML\Core\Twig\Template;

/* layout-reset.twig */
class __TwigTemplate_fd95855ae920c0cddbec1261642a6ca70f78c76ee1a5d202e54d30f3cbe9e425 extends \WPML\Core\Twig\Template
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
        // line 1
        echo "<div class=\"wpml-section\" id=\"wpml_ls_reset\">
\t<div class=\"wpml-section-header\">
\t\t<h3>";
        // line 3
        echo \WPML\Core\twig_escape_filter($this->env, (isset($context["title"]) ? $context["title"] : null), "html", null, true);
        echo "</h3>
\t</div>
\t<div class=\"wpml-section-content\">
\t\t<p>";
        // line 6
        echo (isset($context["description"]) ? $context["description"] : null);
        echo "</p>

\t\t";
        // line 8
        if ((isset($context["theme_config_file"]) ? $context["theme_config_file"] : null)) {
            // line 9
            echo "\t\t\t<p class=\"explanation-text\">";
            echo (isset($context["explanation_text"]) ? $context["explanation_text"] : null);
            echo "</p>
\t\t";
        }
        // line 11
        echo "
\t\t<p class=\"buttons-wrap\">
\t\t\t<a class=\"button button-secondary\" onclick=\"if(!confirm('";
        // line 13
        echo \WPML\Core\twig_escape_filter($this->env, (isset($context["confirmation_message"]) ? $context["confirmation_message"] : null), "html", null, true);
        echo "')) return false;\"
\t\t\t   href=\"";
        // line 14
        echo \WPML\Core\twig_escape_filter($this->env, (isset($context["restore_page_url"]) ? $context["restore_page_url"] : null), "html", null, true);
        echo "\">";
        echo \WPML\Core\twig_escape_filter($this->env, (isset($context["restore_button_label"]) ? $context["restore_button_label"] : null), "html", null, true);
        if ((isset($context["theme_config_file"]) ? $context["theme_config_file"] : null)) {
            echo " *";
        }
        echo "</a>
\t\t</p>
\t</div>
</div>";
    }

    public function getTemplateName()
    {
        return "layout-reset.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  63 => 14,  59 => 13,  55 => 11,  49 => 9,  47 => 8,  42 => 6,  36 => 3,  32 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("", "layout-reset.twig", "/Applications/MAMP/htdocs/mool/wp-content/plugins/sitepress-multilingual-cms/templates/language-switcher-admin-ui/layout-reset.twig");
    }
}
