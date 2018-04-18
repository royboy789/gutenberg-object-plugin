export class SaveBlock {

  constructor() {
    wp.data.subscribe( this.saveCallback.bind(this) );
    this.lastIsSaving = false;
    this.lastDataSent = false;
  }

  saveCallback() {
    const editor = wp.data.select( 'core/editor' );
    let blocks = editor.getBlocks();
    const isSaving = editor.isSavingPost();

    if ( isSaving && ! this.lastIsSaving ) {
      blocks = this.cleanData( blocks );

      if ( blocks === this.lastDataSent ) {
        console.log( 'same data' );
        return;
      }

      this.lastDataSent = blocks;
      jQuery.ajax({
        url: '/wp-json/gutes-db/v1/67',
        method: 'POST',
        data: {
          post_id: 67,
          gutes_data: blocks
        }
      }).then(function(res){
        console.log( res );
      });
    }

    this.lastIsSaving = isSaving;

  }

  cleanData( data ) {
    let new_blocks = [];
    for ( let block of data ) {
      let hookName = block.name.replace( '/', '-' );
      new_blocks.push({
        uid: block.uid,
        name: block.name,
        data: wp.hooks.applyFilters( `clean_data_${hookName}`, block.attributes, block.name, 99 )
      })
    }
    return new_blocks;
  }

}