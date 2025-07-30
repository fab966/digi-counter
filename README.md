# Joomla 5 Animated Counter Module

![Joomla 5 Supported](https://img.shields.io/badge/Joomla-5.x-%234F9F4A?logo=joomla)
![GPL License](https://img.shields.io/badge/license-GPL%20v2%2B-blue)
![Static Badge](https://img.shields.io/badge/version-alpha-orange)

A dynamic counter module for Joomla 5 that displays animated statistics with customizable formatting.

## ✨ Features

- **Smooth Animations**: Number counting with easing effects
- **Flexible Formatting**:
  - Thousands (K) and Millions (M) suffixes
  - Optional "+" sign suffix
  - Localized number formatting (e.g., 1,000 vs 1.000)
- **Smart Triggering**: Animation starts when visible in viewport
- **Responsive Design**: Works on all screen sizes
- **Easy Configuration**:
  - Set target values, labels, and suffixes per counter
  - Control animation duration
- **Lightweight**: Pure CSS/JS without external dependencies

## 📦 Installation

1. Download the latest release ZIP file
2. In your Joomla admin:
   - Go to **System → Install → Extensions**
   - Upload the package file
3. Add the module to a position via **Content → Site Modules**

## ⚙️ Configuration

### Module Options
| Parameter       | Description                          | Default |
|-----------------|--------------------------------------|---------|
| Animation Speed | Duration in milliseconds             | 2000    |
| Columns Layout  | Number of counters per row (1-4)     | 4       |

### Counter Items
Configure each counter with:
- **Target Value**: The number to count up to
- **Label**: Description text below the number
- **Suffix**: None, K (thousands), or M (millions)
- **Plus Sign**: Optionally display "+" after the number

## 🎯 Output Examples

```html
<!-- With suffix and plus sign -->
<div class="counter" data-target="2500" data-suffix="k" data-plus="true">2.5k+</div>

<!-- With million suffix -->
<div class="counter" data-target="3500000" data-suffix="m">3.5m</div>

<!-- Plain number with plus -->
<div class="counter" data-target="99" data-plus="true">99+</div>
```

## 🎨 Customization

### CSS Variables
Override these in your template's CSS:
```css
:root {
    --counter-font-size: 3rem;
    --counter-color: #333;
    --counter-label-color: #666;
    --counter-plus-color: inherit;
}
```

### JavaScript Events
Hook into animation lifecycle:
```javascript
document.addEventListener('counterAnimationStart', (e) => {
    console.log('Animation started for:', e.target);
});

document.addEventListener('counterAnimationEnd', (e) => {
    console.log('Animation completed for:', e.target);
});
```

## 🛠 Development

### Requirements
- Joomla 5.x
- PHP 8.0+
- Browser with JavaScript support

### Building from Source
1. Clone repository
2. Run `npm install` (for SCSS compilation)
3. Make changes in `/src` directory
4. Run `npm run build` to generate production files

## 📜 License

This project is released under the [GNU GPL v2 or later](https://www.gnu.org/licenses/gpl-2.0.html).

## 💙 Credits

Developed & maintained by [Digitest.net](https://digitest.net).  
Inspired by open web standards and Joomla community best practices.

## 🔗 Useful Links

- [Joomla Documentation](https://docs.joomla.org/)
- [Module Development Guide](https://docs.joomla.org/J4.x:Creating_a_Simple_Module)
- [GitHub Issues](https://github.com/your-repo/issues) (for bug reports)

> **Note**: For support questions, please open an issue or contact the maintainer directly.
