export class CoreParagraph {

  constructor() {
    wp.hooks.addFilter( 'clean_data_core-paragraph', 'gutes-array', this.hookCallback.bind(this) );
  }

  hookCallback( attributes, name ) {
    let new_attr = attributes;
    let contentReturn = wp.element.renderToString(
      wp.blocks.getSaveElement(
        wp.blocks.getBlockType( name ),
        new_attr
      )
    );
    new_attr.rendered_content = contentReturn;
    return new_attr;
  }

}