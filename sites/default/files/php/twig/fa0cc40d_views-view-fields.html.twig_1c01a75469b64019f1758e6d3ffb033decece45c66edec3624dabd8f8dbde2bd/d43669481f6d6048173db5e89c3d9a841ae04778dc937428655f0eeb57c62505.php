<?php

/* core/themes/stable/templates/views/views-view-fields.html.twig */
class __TwigTemplate_78a6ecd6946b13785c0d01c135e23ba7a09336977a293f71e682898336d29de0 extends Twig_Template
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
        $__internal_05297a229270c3789c628fa808826c7b0ccba3cd32cc20d547e028bfb02162e6 = $this->env->getExtension("native_profiler");
        $__internal_05297a229270c3789c628fa808826c7b0ccba3cd32cc20d547e028bfb02162e6->enter($__internal_05297a229270c3789c628fa808826c7b0ccba3cd32cc20d547e028bfb02162e6_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "core/themes/stable/templates/views/views-view-fields.html.twig"));

        $tags = array("for" => 32, "if" => 34);
        $filters = array();
        $functions = array();

        try {
            $this->env->getExtension('sandbox')->checkSecurity(
                array('for', 'if'),
                array(),
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

        // line 32
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["fields"]) ? $context["fields"] : null));
        foreach ($context['_seq'] as $context["_key"] => $context["field"]) {
            // line 33
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->getAttribute($context["field"], "separator", array()), "html", null, true));
            // line 34
            if ($this->getAttribute($context["field"], "wrapper_element", array())) {
                // line 35
                echo "<";
                echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->getAttribute($context["field"], "wrapper_element", array()), "html", null, true));
                echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->getAttribute($context["field"], "wrapper_attributes", array()), "html", null, true));
                echo ">";
            }
            // line 37
            if ($this->getAttribute($context["field"], "label", array())) {
                // line 38
                if ($this->getAttribute($context["field"], "label_element", array())) {
                    // line 39
                    echo "<";
                    echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->getAttribute($context["field"], "label_element", array()), "html", null, true));
                    echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->getAttribute($context["field"], "label_attributes", array()), "html", null, true));
                    echo ">";
                    echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->getAttribute($context["field"], "label", array()), "html", null, true));
                    echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->getAttribute($context["field"], "label_suffix", array()), "html", null, true));
                    echo "</";
                    echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->getAttribute($context["field"], "label_element", array()), "html", null, true));
                    echo ">";
                } else {
                    // line 41
                    echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->getAttribute($context["field"], "label", array()), "html", null, true));
                    echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->getAttribute($context["field"], "label_suffix", array()), "html", null, true));
                }
            }
            // line 44
            if ($this->getAttribute($context["field"], "element_type", array())) {
                // line 45
                echo "<";
                echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->getAttribute($context["field"], "element_type", array()), "html", null, true));
                echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->getAttribute($context["field"], "element_attributes", array()), "html", null, true));
                echo ">";
                echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->getAttribute($context["field"], "content", array()), "html", null, true));
                echo "</";
                echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->getAttribute($context["field"], "element_type", array()), "html", null, true));
                echo ">";
            } else {
                // line 47
                echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->getAttribute($context["field"], "content", array()), "html", null, true));
            }
            // line 49
            if ($this->getAttribute($context["field"], "wrapper_element", array())) {
                // line 50
                echo "</";
                echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->getAttribute($context["field"], "wrapper_element", array()), "html", null, true));
                echo ">";
            }
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['field'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        
        $__internal_05297a229270c3789c628fa808826c7b0ccba3cd32cc20d547e028bfb02162e6->leave($__internal_05297a229270c3789c628fa808826c7b0ccba3cd32cc20d547e028bfb02162e6_prof);

    }

    public function getTemplateName()
    {
        return "core/themes/stable/templates/views/views-view-fields.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  97 => 50,  95 => 49,  92 => 47,  82 => 45,  80 => 44,  75 => 41,  64 => 39,  62 => 38,  60 => 37,  54 => 35,  52 => 34,  50 => 33,  46 => 32,);
    }
}
/* {#*/
/* /***/
/*  * @file*/
/*  * Theme override to display all the fields in a row.*/
/*  **/
/*  * Available variables:*/
/*  * - view: The view in use.*/
/*  * - fields: A list of fields, each one contains:*/
/*  *   - content: The output of the field.*/
/*  *   - raw: The raw data for the field, if it exists. This is NOT output safe.*/
/*  *   - class: The safe class ID to use.*/
/*  *   - handler: The Views field handler controlling this field.*/
/*  *   - inline: Whether or not the field should be inline.*/
/*  *   - wrapper_element: An HTML element for a wrapper.*/
/*  *   - wrapper_attributes: List of attributes for wrapper element.*/
/*  *   - separator: An optional separator that may appear before a field.*/
/*  *   - label: The field's label text.*/
/*  *   - label_element: An HTML element for a label wrapper.*/
/*  *   - label_attributes: List of attributes for label wrapper.*/
/*  *   - label_suffix: Colon after the label.*/
/*  *   - element_type: An HTML element for the field content.*/
/*  *   - element_attributes: List of attributes for HTML element for field content.*/
/*  *   - has_label_colon: A boolean indicating whether to display a colon after*/
/*  *     the label.*/
/*  *   - element_type: An HTML element for the field content.*/
/*  *   - element_attributes: List of attributes for HTML element for field content.*/
/*  * - row: The raw result from the query, with all data it fetched.*/
/*  **/
/*  * @see template_preprocess_views_view_fields()*/
/*  *//* */
/* #}*/
/* {% for field in fields -%}*/
/*   {{ field.separator }}*/
/*   {%- if field.wrapper_element -%}*/
/*     <{{ field.wrapper_element }}{{ field.wrapper_attributes }}>*/
/*   {%- endif %}*/
/*   {%- if field.label -%}*/
/*     {%- if field.label_element -%}*/
/*       <{{ field.label_element }}{{ field.label_attributes }}>{{ field.label }}{{ field.label_suffix }}</{{ field.label_element }}>*/
/*     {%- else -%}*/
/*       {{ field.label }}{{ field.label_suffix }}*/
/*     {%- endif %}*/
/*   {%- endif %}*/
/*   {%- if field.element_type -%}*/
/*     <{{ field.element_type }}{{ field.element_attributes }}>{{ field.content }}</{{ field.element_type }}>*/
/*   {%- else -%}*/
/*     {{ field.content }}*/
/*   {%- endif %}*/
/*   {%- if field.wrapper_element -%}*/
/*     </{{ field.wrapper_element }}>*/
/*   {%- endif %}*/
/* {%- endfor %}*/
/* */
