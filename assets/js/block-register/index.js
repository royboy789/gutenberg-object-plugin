class BlockRegister {

  constructor() {
    wp.hooks.addFilter( 'blocks.registerBlockType', 'gutes-array', this.registerCallback, 1 , 1 );
  }

  registerCallback( block ) {

    // if no bid, set it
    if ( block.attributes && ! block.attributes.bid ) {
      block.attributes.bid = {
        type: 'string'
      }
    }
    
    return block;
  }

}

export default BlockRegister;