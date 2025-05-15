<?php

namespace App\Rules;

use Illuminate\Validation\Rules\DatabaseRule;

class UniqueTranslationRule
{
    use DatabaseRule;

    /**
     * The name of the validation rule.
     *
     * @var string
     */
    protected string $rule = 'unique_translation';

    /**
     * The value of the 'ignoreColumn' to ignore.
     *
     * @var mixed
     */
    protected mixed $ignoreValue;

    /**
     * The name of the 'ignoreColumn'.
     *
     * @var string|null
     */
    protected ?string $ignoreColumn;

    /**
     * Create a new rule instance.
     *
     * @param string $table
     * @param string|null $column
     *
     * @return static
     */
    public static function for(string $table, string $column = null): static
    {
        return new static($table, $column);
    }

    /**
     * Create a new rule instance.
     *
     * @param string $table
     * @param string|null $column
     */
    public function __construct($table, $column = null)
    {
        $this->table = $table;
        $this->column = $column;
    }

    /**
     * Ignore any record that has a column with the given value.
     *
     * @param mixed $value
     * @param string $column
     *
     * @return $this
     */
    public function ignore(mixed $value, string $column = 'id'): static
    {
        $this->ignoreValue = $value;
        $this->ignoreColumn = $column;

        return $this;
    }

    /**
     * Generate a string representation of the validation rule.
     *
     * @return string
     */
    public function __toString()
    {
        return rtrim(sprintf(
            '%s:%s,%s,%s,%s,%s',
            $this->rule,
            $this->table,
            $this->column ?: 'NULL',
            $this->ignoreValue ?: 'NULL',
            $this->ignoreColumn ?: 'NULL',
            $this->formatWheres()
        ), ',');
    }
}
