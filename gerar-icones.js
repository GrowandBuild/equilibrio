// Script para gerar ícones PWA em diferentes tamanhos
// Execute: node gerar-icones.js

const fs = require('fs');
const path = require('path');

// SVG base redondinho e bonito
const svgTemplate = `<svg width="SIZE" height="SIZE" viewBox="0 0 512 512" fill="none" xmlns="http://www.w3.org/2000/svg">
  <!-- Fundo redondo com gradiente -->
  <circle cx="256" cy="256" r="256" fill="url(#gradient1)"/>
  
  <!-- Círculo interno branco -->
  <circle cx="256" cy="256" r="180" fill="white" opacity="0.9"/>
  
  <!-- Símbolo de equilíbrio/balança -->
  <g transform="translate(256, 256)">
    <!-- Base da balança -->
    <rect x="-4" y="80" width="8" height="40" fill="url(#gradient1)"/>
    
    <!-- Braço da balança -->
    <rect x="-80" y="70" width="160" height="8" fill="url(#gradient1)"/>
    
    <!-- Pratos da balança -->
    <circle cx="-60" cy="50" r="25" fill="url(#gradient1)" opacity="0.8"/>
    <circle cx="60" cy="50" r="25" fill="url(#gradient1)" opacity="0.8"/>
    
    <!-- Linha de conexão -->
    <line x1="-60" y1="50" x2="-60" y2="70" stroke="url(#gradient1)" stroke-width="3"/>
    <line x1="60" y1="50" x2="60" y2="70" stroke="url(#gradient1)" stroke-width="3"/>
    
    <!-- Símbolo de check nos pratos -->
    <path d="M-70 45 L-55 60 L-50 55" stroke="white" stroke-width="3" fill="none" stroke-linecap="round"/>
    <path d="M50 45 L65 60 L70 55" stroke="white" stroke-width="3" fill="none" stroke-linecap="round"/>
  </g>
  
  <!-- Texto "E" estilizado -->
  <text x="256" y="320" font-family="Arial, sans-serif" font-size="120" font-weight="bold" text-anchor="middle" fill="url(#gradient1)">E</text>
  
  <defs>
    <linearGradient id="gradient1" x1="0" y1="0" x2="512" y2="512" gradientUnits="userSpaceOnUse">
      <stop stop-color="#667eea"/>
      <stop offset="1" stop-color="#764ba2"/>
    </linearGradient>
  </defs>
</svg>`;

// Tamanhos necessários para PWA
const sizes = [72, 96, 128, 144, 152, 192, 384, 512];

// Criar pasta icons se não existir
const iconsDir = path.join(__dirname, 'public', 'icons');
if (!fs.existsSync(iconsDir)) {
    fs.mkdirSync(iconsDir, { recursive: true });
}

// Gerar SVG para cada tamanho
sizes.forEach(size => {
    const svg = svgTemplate.replace(/SIZE/g, size);
    const filename = `icon-${size}x${size}.svg`;
    const filepath = path.join(iconsDir, filename);
    
    fs.writeFileSync(filepath, svg);
    console.log(`✅ Criado: ${filename}`);
});

// Criar também um PNG simples (base64) para teste
const pngBase64 = `iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNkYPhfDwAChwGA60e6kgAAAABJRU5ErkJggg==`;

sizes.forEach(size => {
    const filename = `icon-${size}x${size}.png`;
    const filepath = path.join(iconsDir, filename);
    
    // Para agora, criar um PNG simples (você pode substituir depois)
    fs.writeFileSync(filepath, Buffer.from(pngBase64, 'base64'));
    console.log(`✅ Criado: ${filename} (placeholder)`);
});

console.log('\n🎉 Ícones PWA criados!');
console.log('📝 Para converter SVG para PNG, use um conversor online ou ferramenta local');
console.log('🔗 Recomendado: https://convertio.co/svg-png/');
