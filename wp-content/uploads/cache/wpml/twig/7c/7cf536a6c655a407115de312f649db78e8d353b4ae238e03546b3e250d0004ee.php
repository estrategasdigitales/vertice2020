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

/* status.twig */
class __TwigTemplate_ea0d275cc03b15770327c37b664f261c748e799fd3df040fe2a6a1a4b1dec213 extends \WPML\Core\Twig\Template
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
        echo (isset($context["conf_warnings"]) ? $context["conf_warnings"] : null);
        echo "

";
        // line 3
        echo (isset($context["store_pages"]) ? $context["store_pages"] : null);
        echo "

";
        // line 5
        echo (isset($context["products"]) ? $context["products"] : null);
        echo "

";
        // line 7
        echo (isset($context["taxonomies"]) ? $context["taxonomies"] : null);
        echo "

";
        // line 9
        echo (isset($context["multi_currency"]) ? $context["multi_currency"] : null);
        echo "

";
        // line 11
        echo (isset($context["plugins_status"]) ? $context["plugins_status"] : null);
        echo "

";
        // line 13
        echo (isset($context["media"]) ? $context["media"] : null);
        echo "

<a class=\"alignright wpml-margin-top-sm\" href=\"";
        // line 15
        echo \WPML\Core\twig_escape_filter($this->env, (isset($context["troubl_url"]) ? $context["troubl_url"] : null), "html", null, true);
        echo "\">
    ";
        // line 16
        echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute((isset($context["strings"]) ? $context["strings"] : null), "troubl", []), "html", null, true);
        echo "
</a>";
    }

    public function getTemplateName()
    {
        return "status.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  71 => 16,  67 => 15,  62 => 13,  57 => 11,  52 => 9,  47 => 7,  42 => 5,  37 => 3,  32 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("", "status.twig", "/Applications/MAMP/htdocs/mool/wp-content/plugins/woocommerce-multilingual/templates/status/status.twig");
    }
}
