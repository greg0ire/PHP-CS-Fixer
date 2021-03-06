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

namespace PhpCsFixer\Tests\Fixer\Import;

use PhpCsFixer\Test\AbstractFixerTestCase;
use PhpCsFixer\WhitespacesFixerConfig;

/**
 * @author Ceeram <ceeram@cakephp.org>
 *
 * @internal
 */
final class SingleLineAfterImportsFixerTest extends AbstractFixerTestCase
{
    /**
     * @param string      $expected
     * @param null|string $input
     *
     * @dataProvider provideCases
     */
    public function testFix($expected, $input = null)
    {
        $this->doTest($expected, $input);
    }

    public function provideCases()
    {
        return array(
            array(
                '<?php
use D;
use E;
use DP;   /**/
use EZ; //
use DAZ;
use EGGGG; /**/
use A\B;

use C\DE;


use E\F;



use G\H;

',
                '<?php
use D;         use E;
use DP;   /**/      use EZ; //
use DAZ;         use EGGGG; /**/
use A\B;

use C\DE;


use E\F;



use G\H;
',
            ),
            array(
                '<?php use \Exception;

?>
<?php
$a = new Exception();
',
                '<?php use \Exception?>
<?php
$a = new Exception();
',
            ),
            array(
                '<?php use \stdClass;
use \DateTime;

?>
<?php
$a = new DateTime();
',
                '<?php use \stdClass; use \DateTime?>
<?php
$a = new DateTime();
', ),
            array(
                '<?php namespace Foo;
              '.'
use Bar\Baz;

/**
 * Foo.
 */',
                '<?php namespace Foo;
              '.'
use Bar\Baz;
/**
 * Foo.
 */',
            ),
            array(
                '<?php
namespace A\B;

use D;

class C {}
',
                '<?php
namespace A\B;

use D;
class C {}
',
            ),
            array(
                '<?php
    namespace A\B;

    use D;

    class C {}
',
                '<?php
    namespace A\B;

    use D;
    class C {}
',
            ),
            array(
                '<?php
namespace A\B;

use D;
use E;

class C {}
',
                '<?php
namespace A\B;

use D;
use E;
class C {}
',
            ),
            array(
                '<?php
namespace A\B;

use D;

class C {}
',
                '<?php
namespace A\B;

use D; class C {}
',
            ),
            array(
                '<?php
namespace A\B;
use D;
use E;

{
    class C {}
}',
                '<?php
namespace A\B;
use D; use E; {
    class C {}
}',
            ),
            array(
                '<?php
namespace A\B;
use D;
use E;

{
    class C {}
}',
                '<?php
namespace A\B;
use D;
use E; {
    class C {}
}',
            ),
            array(
                '<?php
namespace A\B {
    use D;
    use E;

    class C {}
}',
                '<?php
namespace A\B {
    use D; use E; class C {}
}',
            ),
            array(
                '<?php
namespace A\B;
class C {
    use SomeTrait;
}',
            ),
            array(
                '<?php
$lambda = function () use (
    $arg
){
    return true;
};',
            ),
            array(
                '<?php
namespace A\B;
use D, E;

class C {

}',
                '<?php
namespace A\B;
use D, E;
class C {

}',
            ),
            array(
                '<?php
    namespace A1;
    use B1; // need to import this !
    use B2;

    class C1 {}
',
            ),
            array(
                '<?php
    namespace A2;
    use B2;// need to import this !
    use B3;

    class C4 {}
',
            ),
            array(
                '<?php
namespace A1;
use B1; // need to import this !
use B2;

class C1 {}
',
            ),
            array(
                '<?php
namespace A1;
use B1;// need to import this !
use B2;

class C1 {}
',
            ),
            array(
                '<?php
namespace A1;
use B1; /** need to import this !*/
use B2;

class C1 {}
',
            ),
            array(
                '<?php
namespace A1;
use B1;# need to import this !
use B2;

class C1 {}
',
            ),
            array(
                '<?php
namespace Foo;

use Bar;
use Baz;

class Hello {}
',
                '<?php
namespace Foo;

use Bar;
use Baz;


class Hello {}
',
            ),
            array(
                '<?php
class HelloTrait {
    use SomeTrait;

    use Another;// ensure use statements for traits are not touched
}
',
            ),
            array(
                '<?php
namespace Foo {}
namespace Bar {
    class Baz
    {
        use Aaa;
    }
}
',
            ),
            array(
                '<?php use A\B;

?>',
                '<?php use A\B?>',
            ),
            array(
                '<?php use A\B;

',
                '<?php use A\B;',
            ),
        );
    }

    /**
     * @param string      $expected
     * @param null|string $input
     *
     * @dataProvider provide70Cases
     * @requires PHP 7.0
     */
    public function test70($expected, $input = null)
    {
        $this->doTest($expected, $input);
    }

    public function provide70Cases()
    {
        return array(
            array(
                '<?php
use some\test\{ClassA, ClassB, ClassC as C};

?>
test 123
',
                '<?php
use some\test\{ClassA, ClassB, ClassC as C}         ?>
test 123
',
            ),
            array(
                '<?php
use some\test\{CA, Cl, ClassC as C};

class Test {}
',
                '<?php
use some\test\{CA, Cl, ClassC as C};
class Test {}
',
            ),
            array(
                '<?php
use function some\test\{fn_g, fn_f, fn_e};

fn_a();',
                '<?php
use function some\test\{fn_g, fn_f, fn_e};
fn_a();',
            ),
            array(
                '<?php
use const some\test\{ConstA, ConstB, ConstD};

',
                '<?php
use const some\test\{ConstA, ConstB, ConstD};
',
            ),
            array(
                '<?php
namespace Z\B;
use const some\test\{ConstA, ConstB, ConstC};
use A\B\C;

',
                '<?php
namespace Z\B;
use const some\test\{ConstA, ConstB, ConstC};
use A\B\C;
',
            ),
        );
    }

    /**
     * @param string      $expected
     * @param null|string $input
     *
     * @dataProvider provideMessyWhitespacesCases
     */
    public function testMessyWhitespaces($expected, $input = null)
    {
        $this->fixer->setWhitespacesConfig(new WhitespacesFixerConfig("\t", "\r\n"));

        $this->doTest($expected, $input);
    }

    public function provideMessyWhitespacesCases()
    {
        return array(
            array(
                "<?php namespace A\B;\r\n    use D;\r\n\r\n    class C {}",
                "<?php namespace A\B;\r\n    use D;\r\n\r\n\r\n    class C {}",
            ),
            array(
                "<?php namespace A\B;\r\n    use D;\r\n\r\n    class C {}",
                "<?php namespace A\B;\r\n    use D;\r\n    class C {}",
            ),
        );
    }
}
