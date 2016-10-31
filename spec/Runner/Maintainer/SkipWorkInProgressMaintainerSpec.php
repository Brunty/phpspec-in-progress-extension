<?php

namespace spec\Brunty\Runner\Maintainer;

use Brunty\Runner\Maintainer\SkipWorkInProgressMaintainer;
use PhpSpec\ObjectBehavior;
use PhpSpec\Loader\Node\ExampleNode;
use PhpSpec\Exception\Example\SkippingException;
use PhpSpec\Runner\Maintainer\Maintainer;
use PhpSpec\Specification;
use PhpSpec\Runner\MatcherManager;
use PhpSpec\Runner\CollaboratorManager;
use PhpSpec\Loader\Node\SpecificationNode;

/**
 * @mixin SkipWorkInProgressMaintainer
 */
class SkipWorkInProgressMaintainerSpec extends ObjectBehavior
{

    function it_is_a_maintainer()
    {
        $this->shouldImplement(Maintainer::class);
    }

    function it_has_a_priority_of_75()
    {
        $this->getPriority()->shouldBe(75);
    }

    /**
     * @param ExampleNode                 $example
     * @param \ReflectionFunctionAbstract $refFunction
     */
    function it_supports_specification_that_has_doc_comment(
        ExampleNode $example,
        \ReflectionFunctionAbstract $refFunction
    ) {
        $example->getFunctionReflection()->willReturn($refFunction);
        $refFunction->getDocComment()->willReturn('doc comment');

        $this->supports($example)->shouldBe(true);
    }

    /**
     * @param ExampleNode                 $example
     * @param SpecificationNode           $specification
     * @param \ReflectionFunctionAbstract $refFunction
     */
    function it_does_not_support_specification_that_does_not_have_doc_comment(
        ExampleNode $example,
        SpecificationNode $specification,
        \ReflectionFunctionAbstract $refFunction
    ) {
        $example->getFunctionReflection()->willReturn($refFunction);
        $refFunction->getDocComment()->willReturn(false);

        $this->supports($example)->shouldBe(false);
    }

    /**
     * @param ExampleNode                 $example
     * @param \ReflectionFunctionAbstract $refFunction
     * @param Specification               $context
     * @param MatcherManager              $matchers
     * @param CollaboratorManager         $collaborators
     */
    function its_prepare_method_throws_skipping_exception_when_specification_is_work_in_progress(
        ExampleNode $example,
        \ReflectionFunctionAbstract $refFunction,
        Specification $context,
        MatcherManager $matchers,
        CollaboratorManager $collaborators
    )
    {
        $example->getFunctionReflection()->willReturn($refFunction);
        $refFunction->getDocComment()->willReturn('/**\n* @wip\n*/');

        $exception = new SkippingException('Spec / example skipped due to being marked as work-in-progress.');
        $this->shouldThrow($exception)->duringPrepare($example, $context, $matchers, $collaborators);
    }

    /**
     * @param ExampleNode                 $example
     * @param \ReflectionFunctionAbstract $refFunction
     * @param Specification               $context
     * @param MatcherManager              $matchers
     * @param CollaboratorManager         $collaborators
     */
    function its_prepare_method_does_not_throw_exception_when_spec_does_not_implement_work_in_progress(
        ExampleNode $example,
        \ReflectionFunctionAbstract $refFunction,
        Specification $context,
        MatcherManager $matchers,
        CollaboratorManager $collaborators
    ) {
        $example->getFunctionReflection()->willReturn($refFunction);
        $refFunction->getDocComment()->willReturn('/**\n\n*/');

        $this->shouldNotThrow('PhpSpec\Exception\Example\SkippingException')->duringPrepare($example, $context, $matchers, $collaborators);
    }

    /**
     * @param ExampleNode                 $example
     * @param \ReflectionFunctionAbstract $refFunction
     * @param Specification               $context
     * @param MatcherManager              $matchers
     * @param CollaboratorManager         $collaborators
     */
    function its_prepare_method_ignores_other_annotation(
        ExampleNode $example,
        \ReflectionFunctionAbstract $refFunction,
        Specification $context,
        MatcherManager $matchers,
        CollaboratorManager $collaborators
    ){

        $example->getFunctionReflection()->willReturn($refFunction);
        $refFunction->getDocComment()->willReturn('/**\n     * @author foo@example.com \n     */');

        $this->shouldNotThrow('PhpSpec\Exception\Example\SkippingException')->duringPrepare($example, $context, $matchers, $collaborators);
    }
}
