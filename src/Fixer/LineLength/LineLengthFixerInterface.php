<?php

namespace PhpCsFixer\Fixer\LineLength;

use PhpCsFixer\Fixer\FixerInterface;

interface LineLengthFixerInterface extends FixerInterface
{
    /**
     * @return PhpCsFixer\FixerDefinition\CodeSample[]
     */
    public function getCodeSamples();
}
