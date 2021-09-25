<?php

  namespace Doox911Opensource\LaravelOData\Attributes;

  use Attribute;
  use Webmozart\Assert\Assert;
  use Doox911Opensource\ValueObjects\Contracts\ValueObjectAssertAttributeContract;

  #[Attribute(Attribute::TARGET_PROPERTY)]
  class StringNotEmpty implements ValueObjectAssertAttributeContract
  {

    /**
     * @see ValueObjectAssertAttributeContract::assert()
     */
    public function assert(mixed $value): void
    {
      Assert::stringNotEmpty($value);
    }
  }
