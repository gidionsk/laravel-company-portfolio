# Design direction

This repository is a public demo portfolio, not a fictional agency website. The interface should show what is actually implemented and label invented project material as concept work.

## Intent

The design is editorial and restrained. It should feel like a developer or product team assembled it deliberately for review, rather than like a generic startup landing page.

## Visual rules

- Use one system sans-serif stack. No external font dependency is required.
- Use warm off-white surfaces, dark ink, one restrained accent, and visible borders.
- Avoid decorative gradients, glass panels, glow effects, fake browser analytics, noise overlays, and ornamental grids.
- Use small corner radii. Cards exist only when they group a real unit of content.
- Do not use invented metrics, client logos, testimonials, or business claims.
- Demo projects must be labelled `Concept case study`.
- Prefer text links with explicit labels over decorative arrow glyphs.
- Motion may reinforce hierarchy and state, but stays finite and restrained: short entrance reveals, ledger sequencing, filter feedback, and subtle hover response. No looping decoration, parallax, cursor-following effects, or autoplay carousels. Content must remain readable with JavaScript disabled.

## Content rules

The public site may claim only features present in this repository, including Laravel, Blade, MySQL, the admin CMS, case-study management, the contact inbox, Docker deployment, and Railway hosting.

Do not publish a testimonial unless it comes from a real person who approved the quote. Do not add a project metric unless it can be substantiated.

## Accessibility

- Normal text must meet WCAG AA contrast.
- Interactive controls must have a visible `:focus-visible` state.
- Mobile touch targets should be at least 44 by 44 pixels.
- Navigation and filters must expose state through accessible attributes where applicable.
- Reduced-motion users should not depend on animation for context.

## Layout rhythm

Energy: 2/5. Rhythm: 3/5. Motion: 2/5.

Sections use generous whitespace, clear dividers, and alternating text/image or text/list structures instead of bento grids and repeated equal-weight cards.


## Motion rules

- Entrance travel stays around 14 pixels and under half a second.
- Reveal each content block once; do not replay on every scroll pass.
- Stagger only tightly related items, such as implementation-ledger rows.
- Hover motion is limited to 1 to 4 pixels and must correspond to an interactive element.
- `prefers-reduced-motion: reduce` removes reveal movement and filter animation.
- Never hide essential content in the no-JavaScript state.
