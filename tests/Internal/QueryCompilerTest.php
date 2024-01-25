<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <https://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\Internal;

use PHPUnit\Framework\TestCase;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;

/**
 * @internal
 *
 * @coversDefaultClass \Linode\Internal\QueryCompiler
 */
final class QueryCompilerTest extends TestCase
{
    protected QueryCompiler $compiler;

    protected function setUp(): void
    {
        $this->compiler = new QueryCompiler();
    }

    /**
     * @covers ::apply
     */
    public function testApply(): void
    {
        $expected = '(class == "standard" or size <= 2500) and (vcpus >= 12 and vcpus <= 20 and is_public == true)';

        $query = '(class == :class or size <= :maxsize) and (vcpus >= :min and vcpus <= :max and is_public == :public)';

        $actual = $this->compiler->apply($query, [
            'class'   => 'standard',
            'min'     => 12,
            'max'     => 20,
            'maxsize' => 2500,
            'public'  => true,
        ]);

        self::assertSame($expected, $actual);
    }

    /**
     * @covers ::apply
     */
    public function testApplyException(): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Parameter "class" contains non-scalar value');

        $query = '(class == :class or size <= :maxsize) and (vcpus >= :min and vcpus <= :max and is_public == :public)';

        $this->compiler->apply($query, [
            'class'   => ['standard'],
            'min'     => 12,
            'max'     => 20,
            'maxsize' => 2500,
            'public'  => true,
        ]);
    }

    /**
     * @covers ::compile
     */
    public function testCompileEqual(): void
    {
        $expected = [
            'label' => 'My gold-master image',
        ];

        $query = 'label == "My gold-master image"';

        $parser = new ExpressionLanguage();
        $ast    = $parser->parse($query, ['label'])->getNodes();

        self::assertSame($expected, $this->compiler->compile($ast));
    }

    /**
     * @covers ::compile
     */
    public function testCompileNotEqual(): void
    {
        $expected = [
            'is_public' => [
                '+neq' => false,
            ],
        ];

        $query = 'is_public != false';

        $parser = new ExpressionLanguage();
        $ast    = $parser->parse($query, ['is_public'])->getNodes();

        self::assertSame($expected, $this->compiler->compile($ast));
    }

    /**
     * @covers ::compile
     */
    public function testCompileLessThan(): void
    {
        $expected = [
            'size' => [
                '+lt' => 2500,
            ],
        ];

        $query = 'size < 2500';

        $parser = new ExpressionLanguage();
        $ast    = $parser->parse($query, ['size'])->getNodes();

        self::assertSame($expected, $this->compiler->compile($ast));
    }

    /**
     * @covers ::compile
     */
    public function testCompileLessThanOrEqual(): void
    {
        $expected = [
            'size' => [
                '+lte' => 2500,
            ],
        ];

        $query = 'size <= 2500';

        $parser = new ExpressionLanguage();
        $ast    = $parser->parse($query, ['size'])->getNodes();

        self::assertSame($expected, $this->compiler->compile($ast));
    }

    /**
     * @covers ::compile
     */
    public function testCompileGreaterThan(): void
    {
        $expected = [
            'size' => [
                '+gt' => 2500,
            ],
        ];

        $query = 'size > 2500';

        $parser = new ExpressionLanguage();
        $ast    = $parser->parse($query, ['size'])->getNodes();

        self::assertSame($expected, $this->compiler->compile($ast));
    }

    /**
     * @covers ::compile
     */
    public function testCompileGreaterThanOrEqual(): void
    {
        $expected = [
            'size' => [
                '+gte' => 2500,
            ],
        ];

        $query = 'size >= 2500';

        $parser = new ExpressionLanguage();
        $ast    = $parser->parse($query, ['size'])->getNodes();

        self::assertSame($expected, $this->compiler->compile($ast));
    }

    /**
     * @covers ::compile
     */
    public function testCompileContains(): void
    {
        $expected = [
            'created' => [
                '+contains' => '2018-08',
            ],
        ];

        $query = 'created ~ "2018-08"';

        $parser = new ExpressionLanguage();
        $ast    = $parser->parse($query, ['created'])->getNodes();

        self::assertSame($expected, $this->compiler->compile($ast));
    }

    /**
     * @covers ::compile
     */
    public function testCompileInvalidExpression(): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Invalid expression');

        $query = 'label';

        $parser = new ExpressionLanguage();
        $ast    = $parser->parse($query, ['label'])->getNodes();

        $this->compiler->compile($ast);
    }

    /**
     * @covers ::compile
     */
    public function testCompileUnknownOperator(): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Unknown operator "+"');

        $query = 'label + "My gold-master image"';

        $parser = new ExpressionLanguage();
        $ast    = $parser->parse($query, ['label'])->getNodes();

        $this->compiler->compile($ast);
    }

    /**
     * @covers ::compile
     */
    public function testCompileLeftOperand(): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Left operand for the "==" operator must be a field name');

        $query = '"label" == "My gold-master image"';

        $parser = new ExpressionLanguage();
        $ast    = $parser->parse($query, ['label'])->getNodes();

        $this->compiler->compile($ast);
    }

    /**
     * @covers ::compile
     */
    public function testCompileRightOperand(): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Right operand for the "==" operator must be a constant value');

        $query = 'label == image';

        $parser = new ExpressionLanguage();
        $ast    = $parser->parse($query, ['label', 'image'])->getNodes();

        $this->compiler->compile($ast);
    }

    /**
     * @covers ::compile
     */
    public function testCompileAnd(): void
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

        self::assertSame($expected, $this->compiler->compile($ast));
    }

    /**
     * @covers ::compile
     */
    public function testCompileOr(): void
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

        self::assertSame($expected, $this->compiler->compile($ast));
    }

    /**
     * @covers ::compile
     */
    public function testCompileComplexQuery(): void
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

        self::assertSame($expected, $this->compiler->compile($ast));
    }
}
