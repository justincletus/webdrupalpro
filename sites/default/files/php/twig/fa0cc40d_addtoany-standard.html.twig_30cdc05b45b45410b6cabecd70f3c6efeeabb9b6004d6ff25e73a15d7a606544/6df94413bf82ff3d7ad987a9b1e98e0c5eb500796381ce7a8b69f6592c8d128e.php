<?php

/* modules/addtoany/templates/addtoany-standard.html.twig */
class __TwigTemplate_5e3d05364913735a851f715e197a9464b4665b1516ec730450695534217c547f extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $__internal_c386524a4d3c605cb0d468b9b9568a0ef3b5eda37ef2628290192c9f7c2abade = $this->env->getExtension("native_profiler");
        $__internal_c386524a4d3c605cb0d468b9b9568a0ef3b5eda37ef2628290192c9f7c2abade->enter($__internal_c386524a4d3c605cb0d468b9b9568a0ef3b5eda37ef2628290192c9f7c2abade_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "modules/addtoany/templates/addtoany-standard.html.twig"));

        $tags = array();
        $filters = array("raw" => 12);
        $functions = array();

        try {
            $this->env->getExtension('sandbox')->checkSecurity(
                array(),
                array('raw'),
                array()
            );
        } catch (Twig_Sandbox_SecurityError $e) {
            $e->setTemplateFile($this->getTemplateName());

            if ($e instanceof Twig_Sandbox_SecurityNotAllowedTagError && isset($tags[$e->getTagName()])) {
                $e->setTemplateLine($tags[$e->getTagName()]);
            } elseif ($e instanceof Twig_Sandbox_SecurityNotAllowedFilterError && isset($filters[$e->getFilterName()])) {
                $e->setTemplateLine($filters[$e->getFilterName()]);
            } elseif ($e instanceof Twig_Sandbox_SecurityNotAllowedFunctionError && isset($functions[$e->getFunctionName()])) {
                $e->setTemplateLine($functions[$e->getFunctionName()]);
            }

            throw $e;
        }

        // line 12
        echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->renderVar((isset($context["addtoany_html"]) ? $context["addtoany_html"] : null)));
        echo "
";
        
        $__internal_c386524a4d3c605cb0d468b9b9568a0ef3b5eda37ef2628290192c9f7c2abade->leave($__internal_c386524a4d3c605cb0d468b9b9568a0ef3b5eda37ef2628290192c9f7c2abade_prof);

    }

    public function getTemplateName()
    {
        return "modules/addtoany/templates/addtoany-standard.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  46 => 12,);
    }
}
/* {#*/
/* /***/
/*  * @file*/
/*  * Default theme implementation to standard AddToAny buttons.*/
/*  **/
/*  * Available variables:*/
/*  * - addtoany_html: HTML for AddToAny buttons.*/
/*  **/
/*  * @ingroup themeable*/
/*  *//* */
/* #}*/
/* {{ addtoany_html|raw }}*/
/* */
