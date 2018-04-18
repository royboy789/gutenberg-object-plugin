export class CoreParagraph {

  constructor() {
    wp.hooks.addFilter( 'clean_data_core-paragraph', 'gutes-array', this.hookCallback.bind(this) );
  }

  hookCallback( attributes, name ) {
    const contentReturn = wp.element.renderToString(
      wp.blocks.getSaveElement(
        wp.blocks.getBlockType( name ),
        attributes
      )
    );
    return { content: contentReturn };
  }

}