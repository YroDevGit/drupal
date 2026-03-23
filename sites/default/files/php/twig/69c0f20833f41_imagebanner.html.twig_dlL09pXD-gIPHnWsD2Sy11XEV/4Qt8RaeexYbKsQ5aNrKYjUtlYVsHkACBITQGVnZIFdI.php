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

/* modules/custom/imagebanner/templates/imagebanner.html.twig */
class __TwigTemplate_bf653c64d4fd90ea6b8da9eb5534c5ee extends Template
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
        yield "<div class=\"container\">
  <div class=\"image-banner-block\" style=\"background-image: url(";
        // line 2
        (((CoreExtension::getAttribute($this->env, $this->source, ($context["img"] ?? null), "image_url", [], "any", true, true, true, 2) &&  !(null === CoreExtension::getAttribute($this->env, $this->source, ($context["img"] ?? null), "image_url", [], "any", false, false, true, 2)))) ? (yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["img"] ?? null), "image_url", [], "any", false, false, true, 2), "html", null, true)) : (yield "https://images.unsplash.com/photo-1497366216548-37526070297c?ixlib=rb-4.0.3&auto=format&fit=crop&w=2000&q=80"));
        yield ");\">
    <div class=\"banner-content\">
      <!-- Badge / Eyebrow (optional) -->
      ";
        // line 5
        if (($context["promotion"] ?? null)) {
            // line 6
            yield "      <span style=\"display: inline-block; background: rgba(255,255,255,0.2); backdrop-filter: blur(4px); padding: 0.25rem 0.875rem; border-radius: 2rem; font-size: 0.75rem; font-weight: 600; margin-bottom: 1rem; letter-spacing: 0.5px;\">
        ";
            // line 7
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["promotion"] ?? null), 7, $this->source), "html", null, true);
            yield "
      </span>
      ";
        }
        // line 10
        yield "

      <!-- Title -->
      <h1 class=\"banner-title\">";
        // line 13
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["title"] ?? null), 13, $this->source), "html", null, true);
        yield "</h1>

      <!-- Description -->
      <p class=\"banner-description\">
        ";
        // line 17
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["description"] ?? null), 17, $this->source), "html", null, true);
        yield "
      </p>

      <!-- Button -->
      ";
        // line 21
        if (($context["buttontext"] ?? null)) {
            // line 22
            yield "        <a href=\"";
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["buttonurl"] ?? null), 22, $this->source), "html", null, true);
            yield "\" class=\"banner-btn\">
        ";
            // line 23
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["buttontext"] ?? null), 23, $this->source), "html", null, true);
            yield " →
        </a>
      ";
        }
        // line 26
        yield "
    </div>
  </div>
</div>
";
        $this->env->getExtension('\Drupal\Core\Template\TwigExtension')
            ->checkDeprecations($context, ["img", "promotion", "title", "description", "buttontext", "buttonurl"]);        return; yield '';
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName()
    {
        return "modules/custom/imagebanner/templates/imagebanner.html.twig";
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
        return array (  92 => 26,  86 => 23,  81 => 22,  79 => 21,  72 => 17,  65 => 13,  60 => 10,  54 => 7,  51 => 6,  49 => 5,  43 => 2,  40 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "modules/custom/imagebanner/templates/imagebanner.html.twig", "C:\\xampp\\htdocs\\drupal\\modules\\custom\\imagebanner\\templates\\imagebanner.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array("if" => 5);
        static $filters = array("escape" => 2);
        static $functions = array();

        try {
            $this->sandbox->checkSecurity(
                ['if'],
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
