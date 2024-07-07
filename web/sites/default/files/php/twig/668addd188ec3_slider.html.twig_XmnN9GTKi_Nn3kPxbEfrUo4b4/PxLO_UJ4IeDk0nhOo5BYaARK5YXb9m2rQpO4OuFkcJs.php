<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\CoreExtension;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* @xara/template-parts/slider.html.twig */
class __TwigTemplate_28886bb5c483fabeaa6996d318a9d1e4 extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
        $this->sandbox = $this->env->getExtension(SandboxExtension::class);
        $this->checkSecurity();
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 1
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->extensions['Drupal\Core\Template\TwigExtension']->attachLibrary("xara/slider"), "html", null, true);
        yield "
<section class=\"slider\">
  <div class=\"container\">
  <div class=\"slider-container\">
    <div class=\"slider-text\">
      <ul class=\"js-rotating\">
        ";
        // line 7
        if ((($context["slider_code"] ?? null) != "")) {
            // line 8
            yield "          ";
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(Twig\Extension\CoreExtension::striptags($this->sandbox->ensureToStringAllowed(($context["slider_code"] ?? null), 8, $this->source), "<ol>,<ul>,<li>,<p>,<a>,<img>,<video>,<h1>,<h2>,<h3>,<h4>,<h5>,<h6>,<em>,<strong>,<br>,<i>,<button>,<mark>,<hr>,<div>"));
            yield "
        ";
        } else {
            // line 10
            yield "        <li>
  \t\t\t\t<h1>Simple, <em>Modern</em> and Expertly Crafted</h1>
  \t\t\t\t<p>XARA is packed full of all the amazing features and options for you to create an amazing edication website.</p>
  \t\t\t\t<a class=\"button\" href=\"#\">Get Started</a>
  \t\t\t</li>
  \t\t\t<li>
  \t\t\t\t<h1>Light Weight and <em>Fast</em> to boost Performance</h1>
  \t\t\t\t<p>We are committed to your digital performance. With awesome features its amazing fast.</p>
  \t\t\t\t<a class=\"button\" href=\"#\">Get Started</a>
  \t\t\t</li>
  \t\t\t<li>
  \t\t\t\t<h1>Satisfied customer is the best business strategy</h1>
  \t\t\t\t<p>We have high academic programs and fully qualified faculties with over 12 years of teaching experience.</p>
  \t\t\t\t<a class=\"button\" href=\"#\">Get Started</a>
  \t\t\t</li>
        ";
        }
        // line 26
        yield "      </ul> <!--/.home-slider -->
    </div><!-- /slider-text -->
    <div class=\"slider-image\">
      ";
        // line 29
        if ((($context["slider_image_path"] ?? null) != "")) {
            // line 30
            yield "        <img src=\"";
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["slider_image_path"] ?? null), 30, $this->source), "html", null, true);
            yield "\" alt=\"slider image\" />
      ";
        } else {
            // line 32
            yield "        <img src=\"";
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["directory"] ?? null), 32, $this->source), "html", null, true);
            yield "/images/demo/slider.svg\" alt=\"slider image\" />
      ";
        }
        // line 34
        yield "    </div><!-- /slider-image -->
  </div> <!--/.slider-container -->
  </div> <!--/.container -->
</section>
";
        $this->env->getExtension('\Drupal\Core\Template\TwigExtension')
            ->checkDeprecations($context, ["slider_code", "slider_image_path", "directory"]);        return; yield '';
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName()
    {
        return "@xara/template-parts/slider.html.twig";
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
        return array (  94 => 34,  88 => 32,  82 => 30,  80 => 29,  75 => 26,  57 => 10,  51 => 8,  49 => 7,  40 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "@xara/template-parts/slider.html.twig", "/var/www/html/web/themes/contrib/xara/templates/template-parts/slider.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array("if" => 7);
        static $filters = array("escape" => 1, "raw" => 8, "striptags" => 8);
        static $functions = array("attach_library" => 1);

        try {
            $this->sandbox->checkSecurity(
                ['if'],
                ['escape', 'raw', 'striptags'],
                ['attach_library'],
                $this->source
            );
        } catch (SecurityError $e) {
            $e->setSourceContext($this->source);

            if ($e instanceof SecurityNotAllowedTagError && isset($tags[$e->getTagName()])) {
                $e->setTemplateLine($tags[$e->getTagName()]);
            } elseif ($e instanceof SecurityNotAllowedFilterError && isset($filters[$e->getFilterName()])) {
                $e->setTemplateLine($filters[$e->getFilterName()]);
            } elseif ($e instanceof SecurityNotAllowedFunctionError && isset($functions[$e->getFunctionName()])) {
                $e->setTemplateLine($functions[$e->getFunctionName()]);
            }

            throw $e;
        }

    }
}
