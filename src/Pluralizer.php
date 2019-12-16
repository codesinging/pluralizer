<?php
/**
 * Author: CodeSinging <codesinging@gmail.com>
 * Time: 2019/12/16 13:26
 */

namespace CodeSinging\Pluralizer;

use Doctrine\Common\Inflector\Inflector;

class Pluralizer
{
    /**
     * Uncountable word forms.
     *
     * @var array
     */
    public static $uncountable = [
        'audio',
        'bison',
        'cattle',
        'chassis',
        'compensation',
        'coreopsis',
        'data',
        'deer',
        'education',
        'emoji',
        'equipment',
        'evidence',
        'feedback',
        'firmware',
        'fish',
        'furniture',
        'gold',
        'hardware',
        'information',
        'jedi',
        'kin',
        'knowledge',
        'love',
        'metadata',
        'money',
        'moose',
        'news',
        'nutrition',
        'offspring',
        'plankton',
        'pokemon',
        'police',
        'rain',
        'recommended',
        'related',
        'rice',
        'series',
        'sheep',
        'software',
        'species',
        'swine',
        'traffic',
        'wheat',
    ];

    /**
     * Get the plural form of an English word.
     *
     * @param  string  $value
     * @param  int     $count
     * @return string
     */
    public static function plural($value, $count = 2)
    {
        if ((int) abs($count) === 1 || static::uncountable($value)) {
            return $value;
        }

        $plural = Inflector::pluralize($value);

        return static::matchCase($plural, $value);
    }

    /**
     * Pluralize the last word of an English, studly caps case string.
     *
     * @param  string  $value
     * @param  int     $count
     * @return string
     */
    public static function pluralStudly($value, $count = 2)
    {
        $parts = preg_split('/(.)(?=[A-Z])/u', $value, -1, PREG_SPLIT_DELIM_CAPTURE);

        $lastWord = array_pop($parts);

        return implode('', $parts).self::plural($lastWord, $count);
    }

    /**
     * Get the singular form of an English word.
     *
     * @param  string  $value
     * @return string
     */
    public static function singular($value)
    {
        $singular = Inflector::singularize($value);

        return static::matchCase($singular, $value);
    }

    /**
     * Determine if the given value is uncountable.
     *
     * @param  string  $value
     * @return bool
     */
    protected static function uncountable($value)
    {
        return in_array(strtolower($value), static::$uncountable);
    }

    /**
     * Attempt to match the case on two strings.
     *
     * @param  string  $value
     * @param  string  $comparison
     * @return string
     */
    protected static function matchCase($value, $comparison)
    {
        $functions = ['mb_strtolower', 'mb_strtoupper', 'ucfirst', 'ucwords'];

        foreach ($functions as $function) {
            if ($function($comparison) === $comparison) {
                return $function($value);
            }
        }

        return $value;
    }
}