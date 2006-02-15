<?php
/**
 * Interface for builders which can register builders with a given identification.
 *
 * This interface relates to ezcMockIdentityBuilder
 */
interface ezcMockBuilderNamespace
{
    /**
     * Looks up the match builder with identification $id and returns it.
     *
     * @param string $id The identifiction of the match builder.
     * @return ezcMockMatchBuilder
     */
    public function lookupId( $id );

    /**
     * Registers the match builder $builder with the identification $id. The
     * builder can later be looked up using lookupId() to figure out if it
     * has been invoked.
     *
     * @param string $id The identification of the match builder.
     * @param ezcMockMatchBuilder $builder The builder which is being registered.
     */
    public function registerId( $id, ezcMockMatchBuilder $builder );
}
?>
