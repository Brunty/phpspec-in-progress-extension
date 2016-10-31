<?php

namespace Brunty\Runner\Maintainer;

use PhpSpec\Runner\Maintainer\Maintainer;
use PhpSpec\Loader\Node\ExampleNode;
use PhpSpec\Specification;
use PhpSpec\Runner\MatcherManager;
use PhpSpec\Runner\CollaboratorManager;
use PhpSpec\Exception\Example\SkippingException;

class SkipWorkInProgressMaintainer implements Maintainer
{

    /**
     * {@inheritdoc}
     */
    public function supports(ExampleNode $example)
    {
        return $this->getDocComment($example) !== false;
    }

    /**
     * {@inheritdoc}
     */
    public function prepare(
        ExampleNode $example,
        Specification $context,
        MatcherManager $matchers,
        CollaboratorManager $collaborators
    ) {
        
        if ($docComment = $this->getDocComment($example)) {
            if ($this->isWorkInProgress($docComment)) {
                throw new SkippingException('Spec / example skipped due to being marked as work-in-progress.');
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function teardown(
        ExampleNode $example,
        Specification $context,
        MatcherManager $matchers,
        CollaboratorManager $collaborators
    ) {
    }

    /**
     * {@inheritdoc}
     */
    public function getPriority()
    {
        return 75;
    }

    /**
     * @param string $docComment
     *
     * @return boolean
     */
    protected function isWorkInProgress($docComment)
    {
        return strpos($docComment, '@wip');
    }

    /**
     * Get spec doc comment
     *
     * @param ExampleNode $example
     *
     * @return string|false
     */
    protected function getDocComment(ExampleNode $example)
    {
        return $example->getFunctionReflection()->getDocComment();
    }
}
