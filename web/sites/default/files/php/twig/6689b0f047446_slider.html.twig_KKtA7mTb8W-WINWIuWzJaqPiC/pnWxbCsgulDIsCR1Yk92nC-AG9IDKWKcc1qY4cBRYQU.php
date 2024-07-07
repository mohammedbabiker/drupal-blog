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

/* @mahi/parts/slider.html.twig */
class __TwigTemplate_2ff20724ea6cbc478952585380dc017d extends Template
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
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->extensions['Drupal\Core\Template\TwigExtension']->attachLibrary("mahi/slider"), "html", null, true);
        yield "
<div class=\"slider\">
  <div class=\"container\">
    <div class=\"splide\" role=\"group\" aria-label=\"webSite slider\">
      <div class=\"splide__track\">
        <ul class=\"splide__list\">
          ";
        // line 7
        if ((($context["slider_code"] ?? null) != "")) {
            // line 8
            yield "            ";
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(Twig\Extension\CoreExtension::striptags($this->sandbox->ensureToStringAllowed(($context["slider_code"] ?? null), 8, $this->source), "<ol>,<ul>,<li>,<p>,<a>,<img>,<video>,<audio>,<h1>,<h2>,<h3>,<h4>,<em>,<strong>,<br>,<i>,<div>,<span>,<button>,<mark>,<hr>,<del>,<sup>,<sub>,<svg>"));
            yield "
          ";
        } else {
            // line 10
            yield "          <li class=\"splide__slide\">
            <div class=\"slider-text\">
              <h2>Mahi is Multipurpose Drupal theme</h2>
              <p>Mahi Theme is packed full of all the amazing features and options for you to create a successful website</p>
              <div><a class=\"button\" href=\"#\">Get Started</a> <a class=\"button-secondary\" href=\"#\">Read More</a></div>
            </div>
            <div class=\"slider-img\">
              <img src=\"";
            // line 17
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["directory"] ?? null), 17, $this->source), "html", null, true);
            yield "/images/demo/slider1.svg\" alt=\"Multipurpose Drupal theme\" />
            </div>
          </li>
          <li class=\"splide__slide\">
            <div class=\"slider-text\">
              <h2>Welcome To Drupar Design Studio</h2>
              <p>We present you material design. We put our hearts and soul into making every project.</p>
            <div><a class=\"button\" href=\"#\">Get Started</a> <a class=\"button-secondary\" href=\"#\">Read More</a></div>
            </div>
            <div class=\"slider-img\">
              <img src=\"";
            // line 27
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["directory"] ?? null), 27, $this->source), "html", null, true);
            yield "/images/demo/slider2.svg\" alt=\"Drupar Design Studio\" />
            </div>
          </li>
          <li class=\"splide__slide\">
            <div class=\"slider-text\">
              <h2>We Create Awesome Drupal Themes!</h2>
              <p>Our themes are of high quality, flexible and beautifully crafted that stand out of crowd.</p>
            <div><a class=\"button\" href=\"#\">Get Started</a> <a class=\"button-secondary\" href=\"#\">Read More</a></div>
            </div>
            <div class=\"slider-img\">
              <img src=\"";
            // line 37
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["directory"] ?? null), 37, $this->source), "html", null, true);
            yield "/images/demo/slider3.svg\" alt=\"Awesome Drupal Theme\" />
            </div>
          </li>
          ";
        }
        // line 41
        yield "        </ul>
      </div><!--/splide__track -->
    </div><!--/splide-->
  </div><!--/container-->
</div><!--/slider-->
<script>
  document.addEventListener( 'DOMContentLoaded', function() {
    var splide = new Splide( '.splide', {
      perPage: 1,
      autoplay: true,
      rewind: true,
      pauseOnHover: false,
      interval: 5000,
      arrowPath: 'M0.5 1L20 20.5L0.5 41.5',
    } );
    splide.mount();
  } );
</script>
";
        $this->env->getExtension('\Drupal\Core\Template\TwigExtension')
            ->checkDeprecations($context, ["slider_code", "directory"]);        return; yield '';
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName()
    {
        return "@mahi/parts/slider.html.twig";
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
        return array (  99 => 41,  92 => 37,  79 => 27,  66 => 17,  57 => 10,  51 => 8,  49 => 7,  40 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "@mahi/parts/slider.html.twig", "/var/www/html/web/themes/contrib/mahi/templates/parts/slider.html.twig");
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
