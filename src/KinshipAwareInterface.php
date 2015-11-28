<?php

namespace phamily\framework;

/**
 * @author samizdam
 */
interface KinshipAwareInterface
{
    const WITHOUT_KINSHIP       = 0;

    const FATHER                = 0b0000000000000001;
    const MOTHER                = 0b0000000000000010;
    const PARENTS               = 0b0000000000000011;

    const SON                   = 0b0000000000000100;
    const DAUGHTER              = 0b0000000000001000;

    const CHILDREN              = 0b0000000000001100;

    const HUSBAND               = 0b0000000000010000;
    const WIFE                  = 0b0000000000100000;
    const SPOUSES               = 0b0000000000110000;
    const BROTHER               = 0b0000000001000000;

    const SISTER                = 0b0000000010000000;

    const FULL_SIBLINGS         = 0b0000000011000000;

    const HALF_BROTHER_PATERNAL = 0b0000000100000000;
    const HALF_SISTER_PATERNAL  = 0b0000001000000000;
    const HALF_SIBLING_PATERNAL = 0b0000001100000000;
    const HALF_BROTHER_MATERNAL = 0b0000010000000000;
    const HALF_SISTER_MATERNAL  = 0b0000100000000000;
    const HALF_SIBLING_MATERNAL = 0b0000110000000000;

    const HALF_BROTHER          = 0b0000010100000000;
    const HALF_SISTER           = 0b0000101000000000;

    const HALF_SIBLING          = 0b0000111100000000;

    const SIBLINGS              = 0b0000111111000000;

    const ALL_KINSHIP           = 0b1111111111111111;
}
