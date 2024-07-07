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

/* themes/contrib/mahi/templates/layout/page.html.twig */
class __TwigTemplate_73bbee582d6e7d43d323a7e2fe58f9d9 extends Template
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
        // line 34
        yield from         $this->loadTemplate("@mahi/parts/header.html.twig", "themes/contrib/mahi/templates/layout/page.html.twig", 34)->unwrap()->yield($context);
        // line 35
        yield from         $this->loadTemplate("@mahi/parts/highlighted.html.twig", "themes/contrib/mahi/templates/layout/page.html.twig", 35)->unwrap()->yield($context);
        // line 36
        yield "<div id=\"main-wrapper\" class=\"main-wrapper\">
  <div class=\"container\">
    <div class=\"main-container\">
      <main id=\"main\" class=\"page-content\">
        <a id=\"main-content\" tabindex=\"-1\"></a>";
        // line 41
        yield "        ";
        if ((($context["is_front"] ?? null) && CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "content_home", [], "any", false, false, true, 41))) {
            // line 42
            yield "          ";
            yield from             $this->loadTemplate("@mahi/parts/content_home.html.twig", "themes/contrib/mahi/templates/layout/page.html.twig", 42)->unwrap()->yield($context);
            // line 43
            yield "        ";
        }
        // line 44
        yield "        ";
        yield from         $this->loadTemplate("@mahi/parts/content_top.html.twig", "themes/contrib/mahi/templates/layout/page.html.twig", 44)->unwrap()->yield($context);
        // line 45
        yield "        ";
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "content", [], "any", false, false, true, 45), 45, $this->source), "html", null, true);
        yield "
        ";
        // line 46
        yield from         $this->loadTemplate("@mahi/parts/content_bottom.html.twig", "themes/contrib/mahi/templates/layout/page.html.twig", 46)->unwrap()->yield($context);
        // line 47
        yield "      </main>
      ";
        // line 48
        yield from         $this->loadTemplate("@mahi/parts/sidebar-left.html.twig", "themes/contrib/mahi/templates/layout/page.html.twig", 48)->unwrap()->yield($context);
        // line 49
        yield "      ";
        yield from         $this->loadTemplate("@mahi/parts/sidebar-right.html.twig", "themes/contrib/mahi/templates/layout/page.html.twig", 49)->unwrap()->yield($context);
        // line 50
        yield "    </div> ";
        // line 51
        yield "  </div> ";
        // line 52
        yield "</div>";
        // line 53
        yield from         $this->loadTemplate("@mahi/parts/footer.html.twig", "themes/contrib/mahi/templates/layout/page.html.twig", 53)->unwrap()->yield($context);
        $this->env->getExtension('\Drupal\Core\Template\TwigExtension')
            ->checkDeprecations($context, ["is_front", "page"]);        return; yield '';
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName()
    {
        return "themes/contrib/mahi/templates/layout/page.html.twig";
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
        return array (  83 => 53,  81 => 52,  79 => 51,  77 => 50,  74 => 49,  72 => 48,  69 => 47,  67 => 46,  62 => 45,  59 => 44,  56 => 43,  53 => 42,  50 => 41,  44 => 36,  42 => 35,  40 => 34,);
    }

    public function getSourceContext()
    {
        return new Source("", "themes/contrib/mahi/templates/layout/page.html.twig", "/var/www/html/web/themes/contrib/mahi/templates/layout/page.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array("include" => 34, "if" => 41);
        static $filters = array("escape" => 45);
        static $functions = array();

        try {
            $this->sandbox->checkSecurity(
                ['include', 'if'],
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
