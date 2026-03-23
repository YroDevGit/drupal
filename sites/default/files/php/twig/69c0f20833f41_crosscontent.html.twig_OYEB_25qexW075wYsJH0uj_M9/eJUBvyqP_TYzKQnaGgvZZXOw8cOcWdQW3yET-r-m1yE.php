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

/* modules/custom/crosscontent/templates/crosscontent.html.twig */
class __TwigTemplate_1bc5bd01aea14527304b66324cea2174 extends Template
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
        yield "<div class='container'>
\t<div class=\"text-center mb-5\">
\t\t<span class=\"badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill fw-semibold mb-3\">✦ cross content</span>
\t\t<h2 class=\"display-5 fw-bold\">";
        // line 4
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["title"] ?? null), 4, $this->source), "html", null, true);
        yield "</h2>
\t\t<p class=\"lead text-secondary col-lg-8 mx-auto\">";
        // line 5
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["description"] ?? null), 5, $this->source), "html", null, true);
        yield "</p>
\t</div>

\t<!-- ========== CROSS CONTENT BLOCK ========== -->
\t<div
\t\tclass=\"c-cross-section\">

  ";
        // line 12
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["contents"] ?? null));
        $context['loop'] = [
          'parent' => $context['_parent'],
          'index0' => 0,
          'index'  => 1,
          'first'  => true,
        ];
        if (is_array($context['_seq']) || (is_object($context['_seq']) && $context['_seq'] instanceof \Countable)) {
            $length = count($context['_seq']);
            $context['loop']['revindex0'] = $length - 1;
            $context['loop']['revindex'] = $length;
            $context['loop']['length'] = $length;
            $context['loop']['last'] = 1 === $length;
        }
        foreach ($context['_seq'] as $context["_key"] => $context["item"]) {
            // line 13
            yield "    ";
            if ((0 == CoreExtension::getAttribute($this->env, $this->source, $context["loop"], "index", [], "any", false, false, true, 13) % 2)) {
                // line 14
                yield "      <!-- ITEM 2: Image on LEFT, Text on RIGHT (alternating) -->
\t\t<div
\t\t\tclass=\"c-cross-item row align-items-center g-5\">
\t\t\t<!-- Image Column (Left) -->
\t\t\t<div class=\"col-lg-6 order-1 order-lg-1\">
\t\t\t\t<div class=\"c-cross-image-wrapper\">
\t\t\t\t\t<img src=\"";
                // line 20
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["item"], "image", [], "any", false, false, true, 20), "image_url", [], "any", false, false, true, 20), 20, $this->source), "html", null, true);
                yield "\" height=\"300\" width=\"300\" alt=\"Data analytics dashboard\" class=\"c-cross-image\">
\t\t\t\t</div>
\t\t\t</div>
\t\t\t<!-- Text Column (Right) -->
\t\t\t<div class=\"col-lg-6 order-2 order-lg-2\">
\t\t\t\t<div class=\"c-cross-content\">
\t\t\t\t\t<h3 class=\"c-cross-title\">";
                // line 26
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(CoreExtension::getAttribute($this->env, $this->source, $context["item"], "text", [], "any", false, false, true, 26), 26, $this->source), "html", null, true);
                yield "</h3>
\t\t\t\t\t<p class=\"c-cross-description\">
          ";
                // line 28
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(CoreExtension::getAttribute($this->env, $this->source, $context["item"], "subtitle", [], "any", false, false, true, 28), 28, $this->source), "html", null, true);
                yield "
\t\t\t\t\t</p>
\t\t\t\t\t<ul class=\"c-cross-features\">
          ";
                // line 31
                $context['_parent'] = $context;
                $context['_seq'] = CoreExtension::ensureTraversable(Twig\Extension\CoreExtension::split($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, $context["item"], "checker", [], "any", false, false, true, 31), ";"));
                foreach ($context['_seq'] as $context["_key"] => $context["ckr"]) {
                    // line 32
                    yield "            <li class=\"c-cross-feature-item\">
\t\t\t\t\t\t\t<span class=\"c-cross-feature-icon\">
\t\t\t\t\t\t\t\t<i class=\"fas fa-check\"></i>
\t\t\t\t\t\t\t</span>
\t\t\t\t\t\t\t<span class=\"c-cross-feature-text\">";
                    // line 36
                    yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($context["ckr"], 36, $this->source), "html", null, true);
                    yield "</span>
\t\t\t\t\t\t</li>
          ";
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_iterated'], $context['_key'], $context['ckr'], $context['_parent'], $context['loop']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 39
                yield "\t\t\t\t\t</ul>
\t\t\t\t</div>
\t\t\t</div>
\t\t</div>
    ";
            } else {
                // line 44
                yield "      <!-- ITEM 1: Image on RIGHT, Text on LEFT -->
\t\t<div
\t\t\tclass=\"c-cross-item row align-items-center g-5\">
\t\t\t<!-- Text Column (Left) -->
\t\t\t<div class=\"col-lg-6 order-1 order-lg-1\">
\t\t\t\t<div class=\"c-cross-content\">
\t\t\t\t\t<h3 class=\"c-cross-title\">";
                // line 50
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(CoreExtension::getAttribute($this->env, $this->source, $context["item"], "text", [], "any", false, false, true, 50), 50, $this->source), "html", null, true);
                yield "</h3>
\t\t\t\t\t<p class=\"c-cross-description\">
            ";
                // line 52
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(CoreExtension::getAttribute($this->env, $this->source, $context["item"], "subtitle", [], "any", false, false, true, 52), 52, $this->source), "html", null, true);
                yield "
\t\t\t\t\t</p>
\t\t\t\t\t<ul class=\"c-cross-features\">
          ";
                // line 55
                $context['_parent'] = $context;
                $context['_seq'] = CoreExtension::ensureTraversable(Twig\Extension\CoreExtension::split($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, $context["item"], "checker", [], "any", false, false, true, 55), ";"));
                foreach ($context['_seq'] as $context["_key"] => $context["ckr"]) {
                    // line 56
                    yield "            <li class=\"c-cross-feature-item\">
\t\t\t\t\t\t\t<span class=\"c-cross-feature-icon\">
\t\t\t\t\t\t\t\t<i class=\"fas fa-check\"></i>
\t\t\t\t\t\t\t</span>
\t\t\t\t\t\t\t<span class=\"c-cross-feature-text\">";
                    // line 60
                    yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($context["ckr"], 60, $this->source), "html", null, true);
                    yield "</span>
\t\t\t\t\t\t</li>
          ";
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_iterated'], $context['_key'], $context['ckr'], $context['_parent'], $context['loop']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 63
                yield "\t\t\t\t\t</ul>
\t\t\t\t</div>
\t\t\t</div>
\t\t\t<!-- Image Column (Right) -->
\t\t\t<div class=\"col-lg-6 order-2 order-lg-2\">
\t\t\t\t<div class=\"c-cross-image-wrapper\">
\t\t\t\t\t<img src=\"";
                // line 69
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["item"], "image", [], "any", false, false, true, 69), "image_url", [], "any", false, false, true, 69), 69, $this->source), "html", null, true);
                yield "\" height=\"300\" width=\"300\" alt=\"Team collaboration\" class=\"c-cross-image\">
\t\t\t\t</div>
\t\t\t</div>
\t\t</div>
    ";
            }
            // line 74
            yield "
  ";
            ++$context['loop']['index0'];
            ++$context['loop']['index'];
            $context['loop']['first'] = false;
            if (isset($context['loop']['length'])) {
                --$context['loop']['revindex0'];
                --$context['loop']['revindex'];
                $context['loop']['last'] = 0 === $context['loop']['revindex0'];
            }
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['item'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 76
        yield "
\t</div>
</div>
";
        $this->env->getExtension('\Drupal\Core\Template\TwigExtension')
            ->checkDeprecations($context, ["title", "description", "contents", "loop"]);        return; yield '';
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName()
    {
        return "modules/custom/crosscontent/templates/crosscontent.html.twig";
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
        return array (  202 => 76,  187 => 74,  179 => 69,  171 => 63,  162 => 60,  156 => 56,  152 => 55,  146 => 52,  141 => 50,  133 => 44,  126 => 39,  117 => 36,  111 => 32,  107 => 31,  101 => 28,  96 => 26,  87 => 20,  79 => 14,  76 => 13,  59 => 12,  49 => 5,  45 => 4,  40 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "modules/custom/crosscontent/templates/crosscontent.html.twig", "C:\\xampp\\htdocs\\drupal\\modules\\custom\\crosscontent\\templates\\crosscontent.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array("for" => 12, "if" => 13);
        static $filters = array("escape" => 4, "split" => 31);
        static $functions = array();

        try {
            $this->sandbox->checkSecurity(
                ['for', 'if'],
                ['escape', 'split'],
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
