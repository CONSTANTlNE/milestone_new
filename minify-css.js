const fs = require('fs');
const path = require('path');

// Function to minify CSS by removing comments, extra whitespace, and newlines
function minifyCSS(css) {
    return css
        // Remove comments
        .replace(/\/\*[\s\S]*?\*\//g, '')
        // Remove extra whitespace
        .replace(/\s+/g, ' ')
        // Remove whitespace around certain characters
        .replace(/\s*([{}:;,>+~])\s*/g, '$1')
        // Remove trailing whitespace
        .replace(/\s+$/g, '')
        // Remove leading whitespace
        .replace(/^\s+/g, '')
        // Remove semicolon before closing brace
        .replace(/;}/g, '}')
        // Remove empty rules
        .replace(/[^{}]+{\s*}/g, '')
        .trim();
}

// Function to read and combine CSS files
function combineCSSFiles() {
    const cssFiles = [
        'public/assets/css/style.css',
        'public/css/app.css',
        'public/css/admin-app.css',
        'public/css/auth-app.css',
        'public/css/error-app.css',
        'public/admin/css/style.css',
        'public/backend/assets/css/style.css',
        'public/backend/assets/css/icon.css'
    ];

    let combinedCSS = '';
    
    cssFiles.forEach(file => {
        try {
            if (fs.existsSync(file)) {
                const content = fs.readFileSync(file, 'utf8');
                combinedCSS += `/* ${file} */\n${content}\n\n`;
                console.log(`✓ Added: ${file}`);
            } else {
                console.log(`✗ Not found: ${file}`);
            }
        } catch (error) {
            console.error(`Error reading ${file}:`, error.message);
        }
    });

    return combinedCSS;
}

// Main execution
console.log('Starting CSS minification...\n');

// Combine all CSS files
const combinedCSS = combineCSSFiles();

// Minify the combined CSS
const minifiedCSS = minifyCSS(combinedCSS);

// Write the minified CSS to a new file
const outputFile = 'public/assets/css/style.min.css';
fs.writeFileSync(outputFile, minifiedCSS);

console.log(`\n✓ Minified CSS saved to: ${outputFile}`);
console.log(`Original size: ${combinedCSS.length} characters`);
console.log(`Minified size: ${minifiedCSS.length} characters`);
console.log(`Compression: ${((1 - minifiedCSS.length / combinedCSS.length) * 100).toFixed(1)}%`); 