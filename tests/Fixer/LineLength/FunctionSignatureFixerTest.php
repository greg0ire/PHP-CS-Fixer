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

namespace PhpCsFixer\Tests\Fixer\FunctionNotation;

use PhpCsFixer\Tests\Test\AbstractFixerTestCase;
use PhpCsFixer\Tokenizer\Tokens;
use PhpCsFixer\WhitespacesFixerConfig;

/**
 * @internal
 *
 * @covers \PhpCsFixer\Fixer\LineLength\FunctionSignatureFixer
 */
final class ListFixerTest extends AbstractFixerTestCase
{
    /**
     * @param string      $expected
     * @param null|string $input
     * @param null|array  $configuration
     *
     * @dataProvider testFixProvider
     */
    public function testFix($expected, $input = null, array $configuration = null)
    {
        if (null !== $configuration) {
            $this->fixer->configure($configuration);
        }
        $indent = '    ';
        $lineEnding = "\n";
        if (null !== $input) {
            if (false !== strpos($input, "\t")) {
                $indent = "\t";
            } elseif (preg_match('/\n  \S/', $input)) {
                $indent = '  ';
            }
            if (false !== strpos($input, "\r")) {
                $lineEnding = "\r\n";
            }
        }
        $this->fixer->setWhitespacesConfig(new WhitespacesFixerConfig(
            $indent,
            $lineEnding
        ));

        $this->doTest($expected, $input);
    }

    /**
     * @param string      $expected
     * @param null|string $input
     * @param null|array  $configuration
     *
     * @dataProvider testFixProvider
     */
    public function testFixWithDifferentLineEndings(
        $expected,
        $input = null,
        array $configuration = null
    ) {
        if (null !== $input) {
            $input = str_replace("\n", "\r\n", $input);
        }

        return $this->testFix(
            str_replace("\n", "\r\n", $expected),
            $input,
            $configuration
        );
    }

    public function testFixProvider()
    {
        return [
            'long function signature' => [
                <<<'EXPECTED'
<?php
function connect(
    ?string $sourceId,
    $sourceValue,
    ?string $destId,
    $destValue = null,
    string $reference = null,
    bool $lazy = false,
    bool $weak = false
) {

}
EXPECTED
          ,
          <<<'INPUT'
<?php
function connect(?string $sourceId, $sourceValue, ?string $destId, $destValue = null, string $reference = null, bool $lazy = false, bool $weak = false) {
}
INPUT
            ],
        ];
    }
}
