<?php

//----------------------------------------------------------------------
//
//  Copyright (C) 2018 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
//----------------------------------------------------------------------

namespace Linode\Internal;

use PHPUnit\Framework\TestCase;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;

class QueryCompilerTest extends TestCase
{
    /** @var QueryCompiler */
    protected $compiler;

    protected function setUp()
    {
        $this->compiler = new QueryCompiler();
    }

    public function testApply()
    {
        $expected = '(class == "standard" or size <= 2500) and (vcpus >= 12 and vcpus <= 20 and is_public == true)';

        $query = '(class == :class or size <= :maxsize) and (vcpus >= :min and vcpus <= :max and is_public == :public)';

        /** @noinspection PhpUnhandledExceptionInspection */
        $actual = $this->compiler->apply($query, [
            'class'   => 'standard',
            'min'     => 12,
            'max'     => 20,
            'maxsize' => 2500,
            'public'  => true,
        ]);

        self::assertSame($expected, $actual);
    }

    public function testApplyException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Parameter "class" contains non-scalar value');

        $query = '(class == :class or size <= :maxsize) and (vcpus >= :min and vcpus <= :max and is_public == :public)';

        /** @noinspection PhpUnhandledExceptionInspection */
        $this->compiler->apply($query, [
            'class'   => ['standard'],
            'min'     => 12,
            'max'     => 20,
            'maxsize' => 2500,
            'public'  => true,
        ]);
    }

    public function testCompileEqual()
    {
        $expected = [
            'label' => 'My gold-master image',
        ];

        $query = 'label == "My gold-master image"';

        $parser = new ExpressionLanguage();
        $ast    = $parser->parse($query, ['label'])->getNodes();

        /** @noinspection PhpUnhandledExceptionInspection */
        self::assertSame($expected, $this->compiler->compile($ast));
    }

    public function testCompileNotEqual()
    {
        $expected = [
            'is_public' => [
                '+neq' => false,
            ],
        ];

        $query = 'is_public != false';

        $parser = new ExpressionLanguage();
        $ast    = $parser->parse($query, ['is_public'])->getNodes();

        /** @noinspection PhpUnhandledExceptionInspection */
        self::assertSame($expected, $this->compiler->compile($ast));
    }

    public function testCompileLessThan()
    {
        $expected = [
            'size' => [
                '+lt' => 2500,
            ],
        ];

        $query = 'size < 2500';

        $parser = new ExpressionLanguage();
        $ast    = $parser->parse($query, ['size'])->getNodes();

        /** @noinspection PhpUnhandledExceptionInspection */
        self::assertSame($expected, $this->compiler->compile($ast));
    }

    public function testCompileLessThanOrEqual()
    {
        $expected = [
            'size' => [
                '+lte' => 2500,
            ],
        ];

        $query = 'size <= 2500';

        $parser = new ExpressionLanguage();
        $ast    = $parser->parse($query, ['size'])->getNodes();

        /** @noinspection PhpUnhandledExceptionInspection */
        self::assertSame($expected, $this->compiler->compile($ast));
    }

    public function testCompileGreaterThan()
    {
        $expected = [
            'size' => [
                '+gt' => 2500,
            ],
        ];

        $query = 'size > 2500';

        $parser = new ExpressionLanguage();
        $ast    = $parser->parse($query, ['size'])->getNodes();

        /** @noinspection PhpUnhandledExceptionInspection */
        self::assertSame($expected, $this->compiler->compile($ast));
    }

    public function testCompileGreaterThanOrEqual()
    {
        $expected = [
            'size' => [
                '+gte' => 2500,
            ],
        ];

        $query = 'size >= 2500';

        $parser = new ExpressionLanguage();
        $ast    = $parser->parse($query, ['size'])->getNodes();

        /** @noinspection PhpUnhandledExceptionInspection */
        self::assertSame($expected, $this->compiler->compile($ast));
    }

    public function testCompileContains()
    {
        $expected = [
            'created' => [
                '+contains' => '2018-08',
            ],
        ];

        $query = 'created ~ "2018-08"';

        $parser = new ExpressionLanguage();
        $ast    = $parser->parse($query, ['created'])->getNodes();

        /** @noinspection PhpUnhandledExceptionInspection */
        self::assertSame($expected, $this->compiler->compile($ast));
    }

    public function testCompileInvalidExpression()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Invalid expression');

        $query = 'label';

        $parser = new ExpressionLanguage();
        $ast    = $parser->parse($query, ['label'])->getNodes();

        /** @noinspection PhpUnhandledExceptionInspection */
        $this->compiler->compile($ast);
    }

    public function testCompileUnknownOperator()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Unknown operator "+"');

        $query = 'label + "My gold-master image"';

        $parser = new ExpressionLanguage();
        $ast    = $parser->parse($query, ['label'])->getNodes();

        /** @noinspection PhpUnhandledExceptionInspection */
        $this->compiler->compile($ast);
    }

    public function testCompileLeftOperand()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Left operand for the "==" operator must be a field name');

        $query = '"label" == "My gold-master image"';

        $parser = new ExpressionLanguage();
        $ast    = $parser->parse($query, ['label'])->getNodes();

        /** @noinspection PhpUnhandledExceptionInspection */
        $this->compiler->compile($ast);
    }

    public function testCompileRightOperand()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Right operand for the "==" operator must be a constant value');

        $query = 'label == image';

        $parser = new ExpressionLanguage();
        $ast    = $parser->parse($query, ['label', 'image'])->getNodes();

        /** @noinspection PhpUnhandledExceptionInspection */
        $this->compiler->compile($ast);
    }

    public function testCompileAnd()
    {
        $expected = [
            '+and' => [
                ['vcpus' => 1],
                ['class' => 'standard'],
            ],
        ];

        $query = 'vcpus == 1 and class == "standard"';

        $parser = new ExpressionLanguage();
        $ast    = $parser->parse($query, ['vcpus', 'class'])->getNodes();

        /** @noinspection PhpUnhandledExceptionInspection */
        self::assertSame($expected, $this->compiler->compile($ast));
    }

    public function testCompileOr()
    {
        $expected = [
            '+or' => [
                ['vcpus' => 1],
                ['class' => 'standard'],
            ],
        ];

        $query = 'vcpus == 1 or class == "standard"';

        $parser = new ExpressionLanguage();
        $ast    = $parser->parse($query, ['vcpus', 'class'])->getNodes();

        /** @noinspection PhpUnhandledExceptionInspection */
        self::assertSame($expected, $this->compiler->compile($ast));
    }

    public function testCompileComplexQuery()
    {
        $expected = [
            '+and' => [
                [
                    '+or' => [
                        ['class' => 'standard'],
                        ['class' => 'highmem'],
                    ],
                ],
                [
                    '+and' => [
                        [
                            'vcpus' => [
                                '+gte' => 12,
                            ],
                        ],
                        [
                            'vcpus' => [
                                '+lte' => 20,
                            ],
                        ],
                    ],
                ],
            ],
        ];

        $query = '(class == "standard" or class == "highmem") and (vcpus >= 12 and vcpus <= 20)';

        $parser = new ExpressionLanguage();
        $ast    = $parser->parse($query, ['vcpus', 'class'])->getNodes();

        /** @noinspection PhpUnhandledExceptionInspection */
        self::assertSame($expected, $this->compiler->compile($ast));
    }
}
