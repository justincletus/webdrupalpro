<?php

/* themes/integrity/templates/block--system-branding-block.html.twig */
class __TwigTemplate_641784728c28a43dca2a36f4015e5b7fabbfe1c61dd912df85a5f8dcced70c25 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("block.html.twig", "themes/integrity/templates/block--system-branding-block.html.twig", 1);
        $this->blocks = array(
            'content' => array($this, 'block_content'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "block.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $__internal_285e8e44459df6df809ecc969f181ad234d0a74a8737a6f4070afb4147b7950f = $this->env->getExtension("native_profiler");
        $__internal_285e8e44459df6df809ecc969f181ad234d0a74a8737a6f4070afb4147b7950f->enter($__internal_285e8e44459df6df809ecc969f181ad234d0a74a8737a6f4070afb4147b7950f_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "themes/integrity/templates/block--system-branding-block.html.twig"));

        $tags = array("if" => 17);
        $filters = array("t" => 18);
        $functions = array("url" => 18);

        try {
            $this->env->getExtension('sandbox')->checkSecurity(
                array('if'),
                array('t'),
                array('url')
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

        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_285e8e44459df6df809ecc969f181ad234d0a74a8737a6f4070afb4147b7950f->leave($__internal_285e8e44459df6df809ecc969f181ad234d0a74a8737a6f4070afb4147b7950f_prof);

    }

    // line 16
    public function block_content($context, array $blocks = array())
    {
        $__internal_579ab93ad991fd979249f3b721488a5d926f606f843f92ee49bf98cee21b26cb = $this->env->getExtension("native_profiler");
        $__internal_579ab93ad991fd979249f3b721488a5d926f606f843f92ee49bf98cee21b26cb->enter($__internal_579ab93ad991fd979249f3b721488a5d926f606f843f92ee49bf98cee21b26cb_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "content"));

        // line 17
        echo "  ";
        if ((isset($context["site_logo"]) ? $context["site_logo"] : null)) {
            // line 18
            echo "    <a href=\"";
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->renderVar($this->env->getExtension('drupal_core')->getUrl("<front>")));
            echo "\" title=\"";
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->renderVar(t("Home")));
            echo "\" rel=\"home\" class=\"site-logo\">
      <img src=\"";
            // line 19
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, (isset($context["site_logo"]) ? $context["site_logo"] : null), "html", null, true));
            echo "\" alt=\"";
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->renderVar(t("Home")));
            echo "\" />
    </a>
  ";
        }
        // line 22
        echo "  ";
        if (((isset($context["site_name"]) ? $context["site_name"] : null) || (isset($context["site_slogan"]) ? $context["site_slogan"] : null))) {
            // line 23
            echo "    <div class=\"site-branding-text\">
      ";
            // line 24
            if ((isset($context["site_name"]) ? $context["site_name"] : null)) {
                // line 25
                echo "        <strong class=\"site-name\">
          <a href=\"";
                // line 26
                echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->renderVar($this->env->getExtension('drupal_core')->getUrl("<front>")));
                echo "\" title=\"";
                echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->renderVar(t("Home")));
                echo "\" rel=\"home\">";
                echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, (isset($context["site_name"]) ? $context["site_name"] : null), "html", null, true));
                echo "</a>
        </strong>
      ";
            }
            // line 29
            echo "      ";
            if ((isset($context["site_slogan"]) ? $context["site_slogan"] : null)) {
                // line 30
                echo "        <div class=\"site-slogan\">";
                echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, (isset($context["site_slogan"]) ? $context["site_slogan"] : null), "html", null, true));
                echo "</div>
      ";
            }
            // line 32
            echo "    </div>
  ";
        }
        
        $__internal_579ab93ad991fd979249f3b721488a5d926f606f843f92ee49bf98cee21b26cb->leave($__internal_579ab93ad991fd979249f3b721488a5d926f606f843f92ee49bf98cee21b26cb_prof);

    }

    public function getTemplateName()
    {
        return "themes/integrity/templates/block--system-branding-block.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  112 => 32,  106 => 30,  103 => 29,  93 => 26,  90 => 25,  88 => 24,  85 => 23,  82 => 22,  74 => 19,  67 => 18,  64 => 17,  58 => 16,  11 => 1,);
    }
}
/* {% extends "block.html.twig" %}*/
/* {#*/
/* /***/
/*  * @file*/
/*  * Bartik's theme implementation for a branding block.*/
/*  **/
/*  * Each branding element variable (logo, name, slogan) is only available if*/
/*  * enabled in the block configuration.*/
/*  **/
/*  * Available variables:*/
/*  * - site_logo: Logo for site as defined in Appearance or theme settings.*/
/*  * - site_name: Name for site as defined in Site information settings.*/
/*  * - site_slogan: Slogan for site as defined in Site information settings.*/
/*  *//* */
/* #}*/
/* {% block content %}*/
/*   {% if site_logo %}*/
/*     <a href="{{ url('<front>') }}" title="{{ 'Home'|t }}" rel="home" class="site-logo">*/
/*       <img src="{{ site_logo }}" alt="{{ 'Home'|t }}" />*/
/*     </a>*/
/*   {% endif %}*/
/*   {% if site_name or site_slogan %}*/
/*     <div class="site-branding-text">*/
/*       {% if site_name %}*/
/*         <strong class="site-name">*/
/*           <a href="{{ url('<front>') }}" title="{{ 'Home'|t }}" rel="home">{{ site_name }}</a>*/
/*         </strong>*/
/*       {% endif %}*/
/*       {% if site_slogan %}*/
/*         <div class="site-slogan">{{ site_slogan }}</div>*/
/*       {% endif %}*/
/*     </div>*/
/*   {% endif %}*/
/* {% endblock %}*/
/* */
