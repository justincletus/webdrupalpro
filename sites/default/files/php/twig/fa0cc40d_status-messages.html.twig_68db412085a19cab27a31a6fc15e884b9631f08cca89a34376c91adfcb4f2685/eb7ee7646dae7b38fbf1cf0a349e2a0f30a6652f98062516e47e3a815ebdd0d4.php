<?php

/* themes/integrity/templates/status-messages.html.twig */
class __TwigTemplate_5871ef4caae7ee9fa8403fc12161402fb45fb519842ce65c66b57764d9c1ddd8 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("@classy/misc/status-messages.html.twig", "themes/integrity/templates/status-messages.html.twig", 1);
        $this->blocks = array(
            'messages' => array($this, 'block_messages'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "@classy/misc/status-messages.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $__internal_37043fd25ca7d781db81166eb4a1cfd79aa7e3d821b9cab1913e9cbe94c0032d = $this->env->getExtension("native_profiler");
        $__internal_37043fd25ca7d781db81166eb4a1cfd79aa7e3d821b9cab1913e9cbe94c0032d->enter($__internal_37043fd25ca7d781db81166eb4a1cfd79aa7e3d821b9cab1913e9cbe94c0032d_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "themes/integrity/templates/status-messages.html.twig"));

        $tags = array("if" => 26);
        $filters = array();
        $functions = array("attach_library" => 27);

        try {
            $this->env->getExtension('sandbox')->checkSecurity(
                array('if'),
                array(),
                array('attach_library')
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
        
        $__internal_37043fd25ca7d781db81166eb4a1cfd79aa7e3d821b9cab1913e9cbe94c0032d->leave($__internal_37043fd25ca7d781db81166eb4a1cfd79aa7e3d821b9cab1913e9cbe94c0032d_prof);

    }

    // line 25
    public function block_messages($context, array $blocks = array())
    {
        $__internal_5495c0a2b28159bc0f7fb3f30d08daaac5a5dec730846c911fc985987bbf4a19 = $this->env->getExtension("native_profiler");
        $__internal_5495c0a2b28159bc0f7fb3f30d08daaac5a5dec730846c911fc985987bbf4a19->enter($__internal_5495c0a2b28159bc0f7fb3f30d08daaac5a5dec730846c911fc985987bbf4a19_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "messages"));

        // line 26
        echo "  ";
        if ( !twig_test_empty((isset($context["message_list"]) ? $context["message_list"] : null))) {
            // line 27
            echo "    ";
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->env->getExtension('drupal_core')->attachLibrary("bartik/messages"), "html", null, true));
            echo "
    <div id=\"messages\">
      <div class=\"section clearfix\">
        ";
            // line 30
            $this->displayParentBlock("messages", $context, $blocks);
            echo "
      </div>
    </div>
  ";
        }
        
        $__internal_5495c0a2b28159bc0f7fb3f30d08daaac5a5dec730846c911fc985987bbf4a19->leave($__internal_5495c0a2b28159bc0f7fb3f30d08daaac5a5dec730846c911fc985987bbf4a19_prof);

    }

    public function getTemplateName()
    {
        return "themes/integrity/templates/status-messages.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  74 => 30,  67 => 27,  64 => 26,  58 => 25,  11 => 1,);
    }
}
/* {% extends "@classy/misc/status-messages.html.twig" %}*/
/* {#*/
/* /***/
/*  * @file*/
/*  * Default theme implementation for status messages.*/
/*  **/
/*  * Displays status, error, and warning messages, grouped by type.*/
/*  **/
/*  * An invisible heading identifies the messages for assistive technology.*/
/*  * Sighted users see a colored box. See http://www.w3.org/TR/WCAG-TECHS/H69.html*/
/*  * for info.*/
/*  **/
/*  * Add an ARIA label to the contentinfo area so that assistive technology*/
/*  * user agents will better describe this landmark.*/
/*  **/
/*  * Available variables:*/
/*  * - message_list: List of messages to be displayed, grouped by type.*/
/*  * - status_headings: List of all status types.*/
/*  * - display: (optional) May have a value of 'status' or 'error' when only*/
/*  *   displaying messages of that specific type.*/
/*  **/
/*  * @see template_preprocess_status_messages()*/
/*  *//* */
/* #}*/
/* {% block messages %}*/
/*   {% if message_list is not empty %}*/
/*     {{ attach_library('bartik/messages') }}*/
/*     <div id="messages">*/
/*       <div class="section clearfix">*/
/*         {{ parent() }}*/
/*       </div>*/
/*     </div>*/
/*   {% endif %}*/
/* {% endblock messages %}*/
/* */
