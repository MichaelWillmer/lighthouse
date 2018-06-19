<?php

namespace Nuwave\Lighthouse\Schema\Directives\Fields;

use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Schema\Values\FieldValue;
use Nuwave\Lighthouse\Support\Contracts\FieldResolver;

class MethodDirective extends BaseFieldDirective implements FieldResolver
{
    /**
     * Name of the directive.
     *
     * @return string
     */
    public function name()
    {
        return 'method';
    }

    /**
     * Resolve the field directive.
     *
     * @param FieldValue $value
     *
     * @return FieldValue
     */
    public function resolveField(FieldValue $value)
    {
        $method = $this->associatedArgValue('name', $value->getFieldName());

        return $value->setResolver(function ($root, array $args, $context = null, ResolveInfo $info = null) use ($method) {
            return call_user_func_array([$root, $method], [$args, $context, $info]);
        });
    }
}
