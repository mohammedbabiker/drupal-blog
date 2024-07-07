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

/* @mahi/parts/header.html.twig */
class __TwigTemplate_3f7a2aafc15a9ba19e5b53145124a23f extends Template
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
        yield "<header class=\"header dark\">
  ";
        // line 2
        if (CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "header_top", [], "any", false, false, true, 2)) {
            // line 3
            yield "    <div class=\"header-top\">
      <div class=\"container\">
        <div class=\"header-top-block\">
          ";
            // line 6
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "header_top", [], "any", false, false, true, 6), 6, $this->source), "html", null, true);
            yield "
        </div>
      </div>
    </div>
  ";
        }
        // line 11
        yield "  <div class=\"header-main\">
    <div class=\"container\">
      <div class=\"header-main-container\">
        ";
        // line 14
        if (CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "site_branding", [], "any", false, false, true, 14)) {
            // line 15
            yield "          <div class=\"site-branding-region\">
            ";
            // line 16
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "site_branding", [], "any", false, false, true, 16), 16, $this->source), "html", null, true);
            yield "
          </div> <!--/.site-branding -->
        ";
        }
        // line 19
        yield "        ";
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "search_box", [], "any", false, false, true, 19) || CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "primary_menu", [], "any", false, false, true, 19))) {
            // line 20
            yield "          <div class=\"header-right\">
            ";
            // line 21
            if (CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "primary_menu", [], "any", false, false, true, 21)) {
                // line 22
                yield "              <div class=\"mobile-menu-icon\">
                <span></span>
                <span></span>
                <span></span>
              </div><!-- /mobile-menu -->
              <div class=\"primary-menu-wrapper\">
                <div class=\"menu-wrap\">
                  <div class=\"close-mobile-menu\">X</div>
                  ";
                // line 30
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "primary_menu", [], "any", false, false, true, 30), 30, $this->source), "html", null, true);
                yield "
                </div>
              </div><!-- /primary-menu-wrapper -->
            ";
            }
            // line 34
            yield "            ";
            if (CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "search_box", [], "any", false, false, true, 34)) {
                // line 35
                yield "              <div class=\"search-icon\">
                <i class=\"icon-search\"></i>
              </div> <!--/.search icon -->
              <div class=\"search-box\">
                <div class=\"search-box-close\"></div>
                <div class=\"container\">
                  <div class=\"search-box-content\">
                    ";
                // line 42
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "search_box", [], "any", false, false, true, 42), 42, $this->source), "html", null, true);
                yield "
                  </div>
                </div>
                <div class=\"search-box-close\"></div>
              </div><!--/.search-box -->
            ";
            }
            // line 47
            yield "<!-- end page.search_box -->
          </div><!--/.header-right -->
        ";
        }
        // line 50
        yield "      </div><!--/header-main-container -->
    </div><!--/container-->
  </div><!--/header-main-->
  ";
        // line 53
        if ((($context["is_front"] ?? null) && ($context["slider_show"] ?? null))) {
            // line 54
            yield "    ";
            yield from             $this->loadTemplate("@mahi/parts/slider.html.twig", "@mahi/parts/header.html.twig", 54)->unwrap()->yield($context);
            // line 55
            yield "  ";
        } elseif (( !($context["is_front"] ?? null) && CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "page_header", [], "any", false, false, true, 55))) {
            // line 56
            yield "    <div class=\"page-header\">
      <div class=\"container\">
        ";
            // line 58
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "page_header", [], "any", false, false, true, 58), 58, $this->source), "html", null, true);
            yield "
      </div><!--/container-->
    </div>
  ";
        }
        // line 62
        yield "</header>
";
        $this->env->getExtension('\Drupal\Core\Template\TwigExtension')
            ->checkDeprecations($context, ["page", "is_front", "slider_show"]);        return; yield '';
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName()
    {
        return "@mahi/parts/header.html.twig";
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
        return array (  149 => 62,  142 => 58,  138 => 56,  135 => 55,  132 => 54,  130 => 53,  125 => 50,  120 => 47,  111 => 42,  102 => 35,  99 => 34,  92 => 30,  82 => 22,  80 => 21,  77 => 20,  74 => 19,  68 => 16,  65 => 15,  63 => 14,  58 => 11,  50 => 6,  45 => 3,  43 => 2,  40 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "@mahi/parts/header.html.twig", "/var/www/html/web/themes/contrib/mahi/templates/parts/header.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array("if" => 2, "include" => 54);
        static $filters = array("escape" => 6);
        static $functions = array();

        try {
            $this->sandbox->checkSecurity(
                ['if', 'include'],
                ['escape'],
                [],
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
