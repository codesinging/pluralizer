<?php
/**
 * Author: CodeSinging <codesinging@gmail.com>
 * Time: 2019/12/16 13:38
 */

namespace CodeSinging\Pluralizer\Tests;

use CodeSinging\Pluralizer\Pluralizer;
use PHPUnit\Framework\TestCase;

class PluralizerTest extends TestCase
{
    public function testBasicSingular()
    {
        $this->assertSame('child', Pluralizer::singular('children'));
    }

    public function testBasicPlural()
    {
        $this->assertSame('children', Pluralizer::plural('child'));
        $this->assertSame('cod', Pluralizer::plural('cod'));
    }

    public function testCaseSensitiveSingularUsage()
    {
        $this->assertSame('Child', Pluralizer::singular('Children'));
        $this->assertSame('CHILD', Pluralizer::singular('CHILDREN'));
        $this->assertSame('Test', Pluralizer::singular('Tests'));
    }

    public function testCaseSensitiveSingularPlural()
    {
        $this->assertSame('Children', Pluralizer::plural('Child'));
        $this->assertSame('CHILDREN', Pluralizer::plural('CHILD'));
        $this->assertSame('Tests', Pluralizer::plural('Test'));
        $this->assertSame('children', Pluralizer::plural('cHiLd'));
    }

    public function testIfEndOfWordPlural()
    {
        $this->assertSame('VortexFields', Pluralizer::plural('VortexField'));
        $this->assertSame('MatrixFields', Pluralizer::plural('MatrixField'));
        $this->assertSame('IndexFields', Pluralizer::plural('IndexField'));
        $this->assertSame('VertexFields', Pluralizer::plural('VertexField'));

        // This is expected behavior, use "Pluralizer::pluralStudly" instead.
        $this->assertSame('RealHumen', Pluralizer::plural('RealHuman'));
    }

    public function testPluralWithNegativeCount()
    {
        $this->assertSame('test', Pluralizer::plural('test', 1));
        $this->assertSame('tests', Pluralizer::plural('test', 2));
        $this->assertSame('test', Pluralizer::plural('test', -1));
        $this->assertSame('tests', Pluralizer::plural('test', -2));
    }

    public function testPluralStudly()
    {
        $this->assertPluralStudly('RealHumans', 'RealHuman');
        $this->assertPluralStudly('Models', 'Model');
        $this->assertPluralStudly('VortexFields', 'VortexField');
        $this->assertPluralStudly('MultipleWordsInOneStrings', 'MultipleWordsInOneString');
    }

    public function testPluralStudlyWithCount()
    {
        $this->assertPluralStudly('RealHuman', 'RealHuman', 1);
        $this->assertPluralStudly('RealHumans', 'RealHuman', 2);
        $this->assertPluralStudly('RealHuman', 'RealHuman', -1);
        $this->assertPluralStudly('RealHumans', 'RealHuman', -2);
    }

    private function assertPluralStudly($expected, $value, $count = 2)
    {
        $this->assertSame($expected, Pluralizer::pluralStudly($value, $count));
    }
}