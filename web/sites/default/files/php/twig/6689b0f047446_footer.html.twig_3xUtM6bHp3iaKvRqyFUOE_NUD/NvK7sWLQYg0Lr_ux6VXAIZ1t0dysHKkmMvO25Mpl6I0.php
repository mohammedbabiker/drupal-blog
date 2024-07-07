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

/* @mahi/parts/footer.html.twig */
class __TwigTemplate_30c0c29a04cfea8cbeab01c34d65dd3f extends Template
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
        yield "<footer class=\"footer dark\">
  <div class=\"container footer-container\">
    ";
        // line 3
        if (CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "footer_top", [], "any", false, false, true, 3)) {
            // line 4
            yield "      <section class=\"footer-top footer-region\">
        ";
            // line 5
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "footer_top", [], "any", false, false, true, 5), 5, $this->source), "html", null, true);
            yield "
      </section>
    ";
        }
        // line 7
        yield "<!-- /footer-top -->
    ";
        // line 8
        if (CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "footer", [], "any", false, false, true, 8)) {
            // line 9
            yield "      <section class=\"footer-blocks footer-region\">
        ";
            // line 10
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "footer", [], "any", false, false, true, 10), 10, $this->source), "html", null, true);
            yield "
      </section>
    ";
        }
        // line 12
        yield "<!-- /footer -->
    ";
        // line 13
        if (CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "footer_bottom", [], "any", false, false, true, 13)) {
            // line 14
            yield "      <section class=\"footer-bottom footer-region\">
        ";
            // line 15
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "footer_bottom", [], "any", false, false, true, 15), 15, $this->source), "html", null, true);
            yield "
      </section>
    ";
        }
        // line 17
        yield "<!-- /footer-bottom -->
    ";
        // line 18
        if ((($context["copyright_text"] ?? null) || ($context["all_icons_show"] ?? null))) {
            // line 19
            yield "    <section class=\"footer-bottom-last footer-region\">
      ";
            // line 20
            if (($context["copyright_text"] ?? null)) {
                // line 21
                yield "        <div class=\"copyright\">
          &copy; ";
                // line 22
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->extensions['Twig\Extension\CoreExtension']->formatDate("now", "Y"), "html", null, true);
                yield " ";
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["site_name"] ?? null), 22, $this->source), "html", null, true);
                yield ", All rights reserved.
        </div>
      ";
            }
            // line 24
            yield " <!-- end if copyright -->
        ";
            // line 25
            if (($context["all_icons_show"] ?? null)) {
                // line 26
                yield "          <div class=\"footer-social\">
            ";
                // line 27
                yield from                 $this->loadTemplate("@mahi/parts/social.html.twig", "@mahi/parts/footer.html.twig", 27)->unwrap()->yield($context);
                // line 28
                yield "          </div>
        ";
            }
            // line 29
            yield " <!-- end if all_icons_show -->
    </section><!-- /footer-bottom-last -->
    ";
        }
        // line 32
        yield "  </div><!-- /container -->
</footer>
";
        // line 34
        if (($context["scrolltotop_on"] ?? null)) {
            // line 35
            yield "<div class=\"scrolltop\"><i class=\"icon-arrow-up size-large\"></i></div>
";
        }
        $this->env->getExtension('\Drupal\Core\Template\TwigExtension')
            ->checkDeprecations($context, ["page", "copyright_text", "all_icons_show", "site_name", "scrolltotop_on"]);        return; yield '';
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName()
    {
        return "@mahi/parts/footer.html.twig";
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
        return array (  129 => 35,  127 => 34,  123 => 32,  118 => 29,  114 => 28,  112 => 27,  109 => 26,  107 => 25,  104 => 24,  96 => 22,  93 => 21,  91 => 20,  88 => 19,  86 => 18,  83 => 17,  77 => 15,  74 => 14,  72 => 13,  69 => 12,  63 => 10,  60 => 9,  58 => 8,  55 => 7,  49 => 5,  46 => 4,  44 => 3,  40 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "@mahi/parts/footer.html.twig", "/var/www/html/web/themes/contrib/mahi/templates/parts/footer.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array("if" => 3, "include" => 27);
        static $filters = array("escape" => 5, "date" => 22);
        static $functions = array();

        try {
            $this->sandbox->checkSecurity(
                ['if', 'include'],
                ['escape', 'date'],
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
