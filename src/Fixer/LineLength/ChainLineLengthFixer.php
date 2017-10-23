<?php

/*
 * This file is part of PHP CS Fixer.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *     Dariusz Rumiński <dariusz.ruminski@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace PhpCsFixer\Fixer\LineLength;

use PhpCsFixer\AbstractFixer;
use PhpCsFixer\FixerDefinition\FixerDefinition;
use PhpCsFixer\Fixer\ConfigurationDefinitionFixerInterface;
use PhpCsFixer\Fixer\LineLength\ListFixer;
use PhpCsFixer\Fixer\WhitespacesAwareFixerInterface;
use PhpCsFixer\Tokenizer\Tokens;

final class ChainLineLengthFixer extends AbstractFixer implements ConfigurationDefinitionFixerInterface, WhitespacesAwareFixerInterface
{
    /**
     * @var LineLengthFixerInterface[]
     */
    private $children;

    public function __construct()
    {
        $this->children = [];
        $this->addChild(new ListFixer());
    }

    private function addChild(LineLengthFixerInterface $child)
    {
        $this->children[] = $child;
    }

    /**
     * {@inheritdoc}
     */
    public function getDefinition()
    {
        return new FixerDefinition(
            'There MUST NOT be a hard limit on line length; the soft limit MUST be 120 characters; lines SHOULD be 80 characters or less.',
            array_merge(array_map(function (LineLengthFixerInterface $child) {
                return $child->getCodeSamples();
            }, $this->children))
        );
    }

    public function applyFix(\SplFileInfo $file, Tokens $tokens)
    {
        foreach ($this->children as $child) {
            if ($child->isCandidate($tokens)) {
                $child->applyFix($file, $tokens);
            }
        }
    }

    public function isCandidate(Tokens $tokens)
    {
        // TODO: return if no long line is detected
        foreach ($this->children as $child) {
            if ($child->isCandidate($tokens)) {
                return true;
            }
        }

        return false;
    }
}
