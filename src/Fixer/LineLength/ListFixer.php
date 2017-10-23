<?php

namespace PhpCsFixer\Fixer\LineLength;

use PhpCsFixer\FixerDefinition\CodeSample;
use PhpCsFixer\Fixer\WhitespacesAwareFixerInterface;
use PhpCsFixer\Tokenizer\Tokens;
use PhpCsFixer\WhitespacesFixerConfig;

/**
 * Can selectively fix any list (function/method declaration/call, arrays,
 * calls to list())
 */
final class ListFixer implements LineLengthFixerInterface, WhitespacesAwareFixerInterface
{
    private $whitespaceFixer;

    public function getCodeSamples()
    {
        return [
            new CodeSample(
                'function connect(?string $sourceId, $sourceValue, ?string $destId, $destValue = null, string $reference = null, bool $lazy = false, bool $weak = false);',
                null
            )
        ];
    }

    public function isRisky()
    {
        return false;
    }

    public function fix(\SplFileInfo $file, Tokens $tokens)
    {
    }

    public function isCandidate(Tokens $tokens)
    {
        return $tokens->isTokenKindFound('(') || $tokens->isTokenKindFound('[');
    }

    public function getPriority()
    {
        return 0;
    }

    public function getName()
    {
        return 'list';
    }

    public function supports(\SplFileInfo $file)
    {
        return true;
    }

    public function setWhitespacesConfig(WhitespacesFixerConfig $config)
    {
        $this->whitespacesConfig = $config;
    }
}
