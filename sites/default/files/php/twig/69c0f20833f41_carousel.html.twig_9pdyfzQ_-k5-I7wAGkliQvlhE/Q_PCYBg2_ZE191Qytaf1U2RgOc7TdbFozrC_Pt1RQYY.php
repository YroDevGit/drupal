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

/* modules/custom/carousel/templates/carousel.html.twig */
class __TwigTemplate_3588d2a1c7877319e553bbeef3f90409 extends Template
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
        yield "<div
\tclass=\"container\">
\t<!-- ========== CAROUSEL BLOCK (with c-carousel namespaced classes) ========== -->
\t<div
\t\tclass=\"c-carousel-block\">

\t\t<!-- Header: Title and Description -->
\t\t<div class=\"c-carousel-header\">
\t\t\t<h2 class=\"c-carousel-title text-primary\">";
        // line 9
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["title"] ?? null), 9, $this->source), "html", null, true);
        yield "</h2>
\t\t\t<p class=\"c-carousel-description\">
\t\t\t\t";
        // line 11
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["description"] ?? null), 11, $this->source), "html", null, true);
        yield "
\t\t\t</p>
\t\t</div>

\t\t<!-- Scrollable Carousel -->
\t\t<div
\t\t\tclass=\"c-carousel-scrollable\">
\t\t\t<!-- Navigation Buttons -->
\t\t\t<div class=\"c-carousel-nav-btn c-carousel-nav-left\" id=\"cCarouselScrollLeft\">
\t\t\t\t<i class=\"fas fa-chevron-left\"></i>
\t\t\t</div>
\t\t\t<div class=\"c-carousel-nav-btn c-carousel-nav-right\" id=\"cCarouselScrollRight\">
\t\t\t\t<i class=\"fas fa-chevron-right\"></i>
\t\t\t</div>

\t\t\t<!-- Scrollable Track -->
\t\t\t<div class=\"c-carousel-track-container\" id=\"cCarouselTrackContainer\">
\t\t\t\t<div class=\"c-carousel-track\" id=\"cCarouselTrack\">
\t\t\t\t\t";
        // line 29
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["people"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["item"]) {
            // line 30
            yield "\t\t\t\t\t\t<!-- Carousel Item 1 - Clickable (navigates to URL) -->
\t\t\t\t\t\t<a href=\"mailto::";
            // line 31
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(CoreExtension::getAttribute($this->env, $this->source, $context["item"], "email", [], "any", false, false, true, 31), 31, $this->source), "html", null, true);
            yield "\" class=\"c-carousel-item\" target=\"_blank\" rel=\"noopener noreferrer\">
\t\t\t\t\t\t\t<img src='";
            // line 32
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(CoreExtension::getAttribute($this->env, $this->source, $context["item"], "img", [], "any", false, false, true, 32), 32, $this->source), "html", null, true);
            yield "' alt=\"Sarah Johnson\" class=\"c-carousel-circle-image\">
\t\t\t\t\t\t\t<h3 class=\"c-carousel-item-title\">";
            // line 33
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(CoreExtension::getAttribute($this->env, $this->source, $context["item"], "firstname", [], "any", false, false, true, 33), 33, $this->source), "html", null, true);
            yield " ";
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(CoreExtension::getAttribute($this->env, $this->source, $context["item"], "lastname", [], "any", false, false, true, 33), 33, $this->source), "html", null, true);
            yield "</h3>
\t\t\t\t\t\t\t<p class=\"c-carousel-item-subtitle\">";
            // line 34
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(CoreExtension::getAttribute($this->env, $this->source, $context["item"], "email", [], "any", false, false, true, 34), 34, $this->source), "html", null, true);
            yield "</p>
\t\t\t\t\t\t</a>
\t\t\t\t\t";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['item'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 37
        yield "\t\t\t\t</div>
\t\t\t</div>
\t\t</div>
\t</div>

\t<!-- Demo Note (optional) -->
\t<div class=\"text-center mt-4 text-secondary\" style='display:none;'>
\t\t<small>⬆️ Scrollable carousel — click any profile to open example URL ⬆️</small>
\t</div>
</div>
";
        $this->env->getExtension('\Drupal\Core\Template\TwigExtension')
            ->checkDeprecations($context, ["title", "description", "people"]);        return; yield '';
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName()
    {
        return "modules/custom/carousel/templates/carousel.html.twig";
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
        return array (  106 => 37,  97 => 34,  91 => 33,  87 => 32,  83 => 31,  80 => 30,  76 => 29,  55 => 11,  50 => 9,  40 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "modules/custom/carousel/templates/carousel.html.twig", "C:\\xampp\\htdocs\\drupal\\modules\\custom\\carousel\\templates\\carousel.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array("for" => 29);
        static $filters = array("escape" => 9);
        static $functions = array();

        try {
            $this->sandbox->checkSecurity(
                ['for'],
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
