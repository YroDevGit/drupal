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

/* modules/custom/accordions/templates/accordions.html.twig */
class __TwigTemplate_180a44f6771399f4f8a2654e2c4f5f7d extends Template
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
        yield "<section>
<div class=\"container border-top border-bottom border-start-0 border-end-0\">

<div class=\"my-5 pt-4 pb-3\">
    <div class=\"text-center mb-4\">
      <span class=\"badge bg-info bg-opacity-10 text-info-emphasis px-3 py-2 rounded-pill\">🔄 accordion block</span>
      <h3 class=\"fw-bold mt-2\">";
        // line 7
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["title"] ?? null), 7, $this->source), "html", null, true);
        yield "</h3>
      <p class=\"text-secondary col-md-8 mx-auto\">";
        // line 8
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["description"] ?? null), 8, $this->source), "html", null, true);
        yield "</p>
    </div>

    <div class=\"row justify-content-center\">
      <div class=\"col-lg-8\">
        <div class=\"accordion shadow-sm rounded-4 overflow-hidden\" id=\"faqAccordion\">
          <!-- item 1 -->
          ";
        // line 15
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["accordions"] ?? null));
        foreach ($context['_seq'] as $context["item"] => $context["value"]) {
            // line 16
            yield "
            <div class=\"accordion-item\">
            <h2 class=\"accordion-header\" id=\"heading";
            // line 18
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($context["item"], 18, $this->source), "html", null, true);
            yield "\">
              <button class=\"accordion-button fw-semibold collapsed\" type=\"button\" data-bs-toggle=\"collapse\" data-bs-target=\"#collapse";
            // line 19
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($context["item"], 19, $this->source), "html", null, true);
            yield "\" aria-expanded=\"false\" aria-controls=\"collapseOne\">
                ";
            // line 20
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t($this->sandbox->ensureToStringAllowed(CoreExtension::getAttribute($this->env, $this->source, $context["value"], "title", [], "any", false, false, true, 20), 20, $this->source)));
            yield "
              </button>
            </h2>
            <div id=\"collapse";
            // line 23
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($context["item"], 23, $this->source), "html", null, true);
            yield "\" class=\"accordion-collapse collapse\" aria-labelledby=\"heading";
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($context["item"], 23, $this->source), "html", null, true);
            yield "\" data-bs-parent=\"#faqAccordion\">
              <div class=\"accordion-body bg-light\">
                ";
            // line 25
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t($this->sandbox->ensureToStringAllowed(CoreExtension::getAttribute($this->env, $this->source, $context["value"], "subtitle", [], "any", false, false, true, 25), 25, $this->source)));
            yield "
              </div>
            </div>
          </div>

          ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['item'], $context['value'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 31
        yield "

        <!-- subtle support link -->
        <div class=\"text-center mt-3\">
          <small class=\"text-secondary\">Still have questions? <a href=\"";
        // line 35
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["contact"] ?? null), 35, $this->source), "html", null, true);
        yield "\" target=\"_blank\" class=\"text-decoration-none\">Contact our team</a></small>
        </div>
      </div>
    </div>
  </div>
</div>

</section>
";
        $this->env->getExtension('\Drupal\Core\Template\TwigExtension')
            ->checkDeprecations($context, ["title", "description", "accordions", "contact"]);        return; yield '';
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName()
    {
        return "modules/custom/accordions/templates/accordions.html.twig";
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
        return array (  109 => 35,  103 => 31,  91 => 25,  84 => 23,  78 => 20,  74 => 19,  70 => 18,  66 => 16,  62 => 15,  52 => 8,  48 => 7,  40 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "modules/custom/accordions/templates/accordions.html.twig", "C:\\xampp\\htdocs\\drupal\\modules\\custom\\accordions\\templates\\accordions.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array("for" => 15);
        static $filters = array("escape" => 7, "t" => 20);
        static $functions = array();

        try {
            $this->sandbox->checkSecurity(
                ['for'],
                ['escape', 't'],
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
