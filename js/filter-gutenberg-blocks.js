const coreBlocksArray = [
  "core/paragraph",
  "core/heading",
  "core/list",
  "core/quote",
  "core/pullquote",
  "core/spacer",
];

function qlFiltercoreBlocksCategory(settings, name) {
  if (coreBlocksArray.includes(name)) {
    return Object.assign(settings, {
      category: "writing",
    });
  }

  if (name == "core/columns" || name == "core/table") {
    return Object.assign(settings, {
      category: "custom-blocks",
    });
  }

  return settings;
}

wp.hooks.addFilter(
  "blocks.registerBlockType",
  "ql/filter-core-blocks-category",
  qlFiltercoreBlocksCategory
);

// removing gutenberg side panel settings
wp.domReady(() => {
  // image
  wp.blocks.unregisterBlockStyle("core/image", "rounded");
  wp.blocks.unregisterBlockStyle("core/image", "default");
  // quote
  wp.blocks.unregisterBlockStyle("core/quote", "default");
  wp.blocks.unregisterBlockStyle("core/quote", "large");
  // pullquote
  wp.blocks.unregisterBlockStyle("core/pullquote", "default");
  wp.blocks.unregisterBlockStyle("core/pullquote", "solid-color");
  // separator
  wp.blocks.unregisterBlockStyle("core/separator", "default");
  wp.blocks.unregisterBlockStyle("core/separator", "wide");
  wp.blocks.unregisterBlockStyle("core/separator", "dots");

  // list of unwanted embeds
  wp.blocks.unregisterBlockVariation("core/embed", "amazon-kindle");
  wp.blocks.unregisterBlockVariation("core/embed", "animoto");
  wp.blocks.unregisterBlockVariation("core/embed", "cloudup");
  wp.blocks.unregisterBlockVariation("core/embed", "crowdsignal");
  wp.blocks.unregisterBlockVariation("core/embed", "dailymotion");
  wp.blocks.unregisterBlockVariation("core/embed", "flickr");
  wp.blocks.unregisterBlockVariation("core/embed", "imgur");
  wp.blocks.unregisterBlockVariation("core/embed", "issuu");
  wp.blocks.unregisterBlockVariation("core/embed", "kickstarter");
  wp.blocks.unregisterBlockVariation("core/embed", "mixcloud");
  wp.blocks.unregisterBlockVariation("core/embed", "reddit");
  wp.blocks.unregisterBlockVariation("core/embed", "screencast");
  wp.blocks.unregisterBlockVariation("core/embed", "scribd");
  wp.blocks.unregisterBlockVariation("core/embed", "slideshare");
  wp.blocks.unregisterBlockVariation("core/embed", "smugmug");
  wp.blocks.unregisterBlockVariation("core/embed", "soundcloud");
  wp.blocks.unregisterBlockVariation("core/embed", "speaker-deck");
  wp.blocks.unregisterBlockVariation("core/embed", "spotify");
  wp.blocks.unregisterBlockVariation("core/embed", "tiktok");
  wp.blocks.unregisterBlockVariation("core/embed", "ted");
  wp.blocks.unregisterBlockVariation("core/embed", "twitter");
  wp.blocks.unregisterBlockVariation("core/embed", "tumblr");
  wp.blocks.unregisterBlockVariation("core/embed", "videopress");
  wp.blocks.unregisterBlockVariation("core/embed", "wordpress");
  wp.blocks.unregisterBlockVariation("core/embed", "wordpress-tv");
  wp.blocks.unregisterBlockVariation("core/embed", "pocket-casts");
  wp.blocks.unregisterBlockVariation("core/embed", "pinterest");
  wp.blocks.unregisterBlockVariation("core/embed", "reverbnation");
  wp.blocks.unregisterBlockVariation("core/embed", "wolfram-cloud");
});
