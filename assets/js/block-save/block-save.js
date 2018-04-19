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
    const postId = editor.getCurrentPostId();

    if ( isSaving && ! this.lastIsSaving ) {
      blocks = this.cleanData( blocks );

      if ( blocks === this.lastDataSent ) {
        console.log( 'same data' );
        return;
      }

      this.lastDataSent = blocks;

      wp.apiRequest( {
        path: '/gutes-db/v1/' + postId,
        data: {
          post_id: postId,
          gutes_data: blocks
        },
        method: 'POST',
      } ).then(function(res){
        console.log( res );
      });

    }

    this.lastIsSaving = isSaving;

  }

  cleanData( data ) {
    let newBlocks = [];
    for ( let block of data ) {
      let blockName = block.name.replace( '/', '-' );
      newBlocks.push({
        uid: block.uid,
        name: block.name,
        data: wp.hooks.applyFilters( `clean_data_${blockName}`, block.attributes, block.name, 99 )
      })
    }
    return newBlocks;
  }

}