# 📱 Como Gerar Ícones PWA

## 🎨 **Opção 1: Usar um Gerador Online (RECOMENDADO)**

### 1. **PWA Icon Generator**
🔗 https://www.pwabuilder.com/imageGenerator

1. Faça upload de uma imagem quadrada (512x512 ou maior)
2. Baixe todos os tamanhos gerados
3. Coloque na pasta `public/icons/`

### 2. **Favicon Generator**
🔗 https://realfavicongenerator.net/

1. Upload da imagem
2. Configure para PWA
3. Baixe o pacote
4. Extraia na pasta `public/icons/`

## 🖼️ **Tamanhos Necessários**

Crie estes tamanhos e salve em `public/icons/`:

- `icon-72x72.png`
- `icon-96x96.png`
- `icon-128x128.png`
- `icon-144x144.png`
- `icon-152x152.png`
- `icon-192x192.png`
- `icon-384x384.png`
- `icon-512x512.png`

## 💡 **Dicas**

1. **Use uma imagem simples** - Ícones pequenos precisam ser legíveis
2. **Fundo transparente ou sólido** - Evite gradientes complexos em tamanhos pequenos
3. **Cores vibrantes** - Use as cores do seu tema (#8b5cf6 - roxo do Equilíbrio)
4. **Teste em diferentes dispositivos** - iOS, Android, Desktop

## 🎯 **Sugestão de Design**

Para o Equilíbrio:
- **Símbolo**: ⚖️ ou 📊 ou 🎯
- **Cor de fundo**: Gradiente roxo (#8b5cf6) ou branco
- **Texto**: "E" estilizado ou logo completo
- **Estilo**: Minimalista e moderno

## ✅ **Depois de Criar**

1. Coloque todos os arquivos em `public/icons/`
2. Verifique se os nomes estão corretos
3. Teste no navegador: DevTools > Application > Manifest
4. Teste instalação do PWA no celular

## 🚀 **Upload para Hostinger**

Depois de criar os ícones localmente:

```bash
# Conectar no servidor
ssh -p 65002 u834385447@147.93.39.173

# Ir para a pasta public
cd /home/u834385447/laravel/public

# Criar pasta icons
mkdir -p icons

# Sair do SSH
exit

# Enviar ícones (do seu PC)
scp -P 65002 -r public/icons/* u834385447@147.93.39.173:/home/u834385447/laravel/public/icons/
```

Ou use FileZilla/FTP para fazer upload dos ícones.
