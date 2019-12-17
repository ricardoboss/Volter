/**
 * @param ${TYPE_HINT} $${PARAM_NAME}
 */
 public function set${NAME}Attribute(#if (${SCALAR_TYPE_HINT})${SCALAR_TYPE_HINT} #else#end$${PARAM_NAME})#if(${RETURN_TYPE}): ${CLASS_NAME}#else#end
{
    $this->attributes['${FIELD_NAME}'] = $${PARAM_NAME};
    
    return $this;
}
