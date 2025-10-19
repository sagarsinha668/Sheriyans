<!-- flex grow kia hota h HW -->
Quick SCSS Reference Notes
1. Variables: Storing Reusable Values
Use variables to store information you want to reuse, like colors or fonts. This way, you only need to update the value in one place.

SCSS Code:

SCSS

$main-color: #084cdf;
$main-font: Helvetica, sans-serif;

body {
  background-color: $main-color;
  font-family: $main-font;
}
2. Nesting: Organizing Your Code
Nesting lets you structure your CSS selectors to follow the same visual hierarchy as your HTML. This makes your code cleaner and easier to read.

SCSS Code:

SCSS

.navbar {
  background-color: #333;

  ul {
    list-style-type: none;
  }

  li {
    display: inline-block;

    a {
      color: white;
    }
  }
}
3. Partials & @import: Splitting Up Your Files
Partials are smaller SCSS files that start with an underscore (e.g., _colors.scss). You can use the @import rule to combine these smaller files into one main CSS file, which is great for keeping large projects organized.

_colors.scss:

SCSS

$primary-color: #3498db;
main.scss:

SCSS

@import 'colors';

body {
  background-color: $primary-color;
}
4. Mixins: Reusing Blocks of Styles
A mixin is like a function for CSS. You define a block of styles once and then include it wherever you need it. This is perfect for styles that are used repeatedly, like button designs or flexbox centering.

SCSS Code:

SCSS

// Define the mixin
@mixin center-flex {
  display: flex;
  justify-content: center;
  align-items: center;
}

// Use the mixin
.login-box {
  @include center-flex;
  height: 400px;
}

.icon-container {
  @include center-flex;
}
5. Inheritance (@extend): Sharing a Set of Styles
The @extend rule lets you share a set of CSS properties from one selector to another. This is useful for grouping elements that have a similar base style but might have some minor differences.

SCSS Code:

SCSS

.message {
  border: 1px solid #ccc;
  padding: 10px;
  color: #333;
}

.success-message {
  @extend .message;
  border-color: green;
}

.error-message {
  @extend .message;
  border-color: red;
}