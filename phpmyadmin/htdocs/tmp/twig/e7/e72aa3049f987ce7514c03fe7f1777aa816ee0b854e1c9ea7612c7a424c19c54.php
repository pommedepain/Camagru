<?php

/* database/designer/js_fields.twig */
class __TwigTemplate_503fc8e67729f4125fd189a37cfdb6d19e6f8d96cf2968469a811c57071c79ea extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        // line 2
        ob_start();
        // line 3
        echo "<script type=\"text/javascript\">
var designer_config = ";
        // line 4
        echo (isset($context["designer_config"]) ? $context["designer_config"] : null);
        echo ";
</script>
";
        echo trim(preg_replace('/>\s+</', '><', ob_get_clean()));
    }

    public function getTemplateName()
    {
        return "database/designer/js_fields.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  24 => 4,  21 => 3,  19 => 2,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "database/designer/js_fields.twig", "/Users/psentilh/MAMP/apps/phpmyadmin/htdocs/templates/database/designer/js_fields.twig");
    }
}
