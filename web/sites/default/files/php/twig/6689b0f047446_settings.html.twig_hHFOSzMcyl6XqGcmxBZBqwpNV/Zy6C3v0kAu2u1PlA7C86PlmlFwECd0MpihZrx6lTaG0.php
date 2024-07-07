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

/* @mahi/parts/settings.html.twig */
class __TwigTemplate_b8125630008003f782ad15e21675cf35 extends Template
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
        if (($context["fontawesome_five"] ?? null)) {
            // line 2
            yield "  ";
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->extensions['Drupal\Core\Template\TwigExtension']->attachLibrary("mahi/fontawesome5"), "html", null, true);
            yield "
";
        }
        // line 4
        if (($context["fontawesome_six"] ?? null)) {
            // line 5
            yield "  ";
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->extensions['Drupal\Core\Template\TwigExtension']->attachLibrary("mahi/fontawesome6"), "html", null, true);
            yield "
";
        }
        // line 7
        if (($context["bootstrapicons"] ?? null)) {
            // line 8
            yield "  ";
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->extensions['Drupal\Core\Template\TwigExtension']->attachLibrary("mahi/bootstrap-icons"), "html", null, true);
            yield "
";
        }
        // line 10
        yield "
<style>
.container {
  max-width: ";
        // line 13
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["container_width"] ?? null), 13, $this->source), "html", null, true);
        yield "px;
}
";
        // line 15
        if ((($context["header_width"] ?? null) == "header_width_full")) {
            // line 16
            yield ".header .container {
  max-width: 100%;
}
";
        }
        // line 20
        if ((($context["main_width"] ?? null) == "main_width_full")) {
            // line 21
            yield ".highlighted .container,
.main-wrapper .container {
  max-width: 100%;
}
";
        }
        // line 26
        yield "
";
        // line 27
        if ((($context["footer_width"] ?? null) == "footer_width_full")) {
            // line 28
            yield ".footer .container {
  max-width: 100%;
}
";
        }
        // line 32
        if (($context["highlight_author_comment"] ?? null)) {
            // line 33
            yield ".by-node-author {
  box-shadow: 0 0 0.4rem var(--color-primary);
}
";
        }
        // line 37
        yield "</style>
";
        $this->env->getExtension('\Drupal\Core\Template\TwigExtension')
            ->checkDeprecations($context, ["fontawesome_five", "fontawesome_six", "bootstrapicons", "container_width", "header_width", "main_width", "footer_width", "highlight_author_comment"]);        return; yield '';
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName()
    {
        return "@mahi/parts/settings.html.twig";
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
        return array (  110 => 37,  104 => 33,  102 => 32,  96 => 28,  94 => 27,  91 => 26,  84 => 21,  82 => 20,  76 => 16,  74 => 15,  69 => 13,  64 => 10,  58 => 8,  56 => 7,  50 => 5,  48 => 4,  42 => 2,  40 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "@mahi/parts/settings.html.twig", "/var/www/html/web/themes/contrib/mahi/templates/parts/settings.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array("if" => 1);
        static $filters = array("escape" => 2);
        static $functions = array("attach_library" => 2);

        try {
            $this->sandbox->checkSecurity(
                ['if'],
                ['escape'],
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
