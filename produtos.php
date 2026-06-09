<?php
// helper simples para resolver imagem por ID do jogo sem usar banco
function imagemProdutoUrl(int $jogoId): string
{
    $baseFs = __DIR__ . "/../public/uploads/produtos/";
    $baseUrl = "public/uploads/produtos/";
    foreach (['jpg','png','webp'] as $ext) {
        if (file_exists($baseFs . $jogoId . '.' . $ext)) {
            return $baseUrl . $jogoId . '.' . $ext;
        }
    }
    return "public/assets/img/produto_sem_foto.png";
}
?>
<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <title>Gerenciamento de Jogos - LevelZone</title>
    <link rel="stylesheet" href="public/assets/css/style.css">
</head>
<body>
<div class="header">
    <div class="container header-inner">
        <div>
            <strong>LevelZone Games</strong>
            <span class="badge">Painel de Jogos</span>
        </div>
        <div class="user">
            Olá, <strong><?= htmlspecialchars($_SESSION['nome'] ?? 'Usuário') ?></strong>
            <a class="btn btn-ghost" href="index.php?controller=auth&action=logout">Sair</a>
        </div>
    </div>
</div>

<div class="container grid">
    <div class="card">
        <h2><?= $editar ? "Editar Jogo #".(int)$editar['id_jogo'] : "Cadastrar Jogo" ?></h2>
        <form method="post" action="index.php?controller=produto&action=salvar" enctype="multipart/form-data">
            <input type="hidden" name="id_jogo" value="<?= $editar ? (int)$editar['id_jogo'] : 0 ?>">
            
            <div class="form-group">
                <label>Categoria (Gênero)</label>
                <select class="input" name="id_categoria" required>
                    <option value="">Selecione...</option>
                    <?php foreach ($categorias as $c): ?>
                        <option value="<?= htmlspecialchars($c['id_categoria']) ?>"
                            <?= $editar && $editar['id_categoria'] === $c['id_categoria'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($c['nome']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label>Título do Jogo</label>
                <input class="input" type="text" name="titulo" required
                       value="<?= $editar ? htmlspecialchars($editar['titulo']) : '' ?>">
            </div>

            <div class="form-group">
                <label>Gênero Alternativo</label>
                <input class="input" type="text" name="genero" 
                       value="<?= $editar ? htmlspecialchars($editar['genero'] ?? '') : '' ?>">
            </div>

            <div class="form-group">
                <label>Preço (R$)</label>
                <input class="input" type="number" step="0.01" name="preco" required
                       value="<?= $editar ? (float)$editar['preco'] : '' ?>">
            </div>

            <div class="form-group">
                <label>Estoque Inicial</label>
                <input class="input" type="number" name="estoque" required
                       value="<?= $editar ? (int)$editar['estoque'] : '0' ?>">
            </div>

            <div class="form-group">
                <label>Imagem da Capa (opcional)</label>
                <input class="input" type="file" name="imagem" accept="image/png, image/jpeg, image/webp">
                <small class="muted">Formatos: JPG, PNG, WEBP. Salva como ID do jogo.</small>
            </div>

            <div class="actions">
                <button class="btn btn-primary" type="submit">Salvar</button>
                <a class="btn" href="index.php?controller=produto&action=index">Limpar</a>
            </div>
        </form>
    </div>

    <div class="card">
        <h2>Lista de Jogos Cadastrados</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Capa</th>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Categoria</th>
                    <th>Preço</th>
                    <th>Estoque</th>
                    <th style="width:180px;">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($produtos as $p): ?>
                <tr>
                    <td>
                        <img class="thumb" src="<?= imagemProdutoUrl((int)$p['id_jogo']) ?>" alt="capa" style="width:50px; height:auto;">
                    </td>
                    <td>#<?= (int)$p['id_jogo'] ?></td>
                    <td><strong><?= htmlspecialchars($p['titulo']) ?></strong></td>
                    <td><?= htmlspecialchars($p['categoria_nome'] ?? $p['id_categoria']) ?></td>
                    <td>R$ <?= number_format($p['preco'], 2, ',', '.') ?></td>
                    <td><?= (int)$p['estoque'] ?> un.</td>
                    <td>
                        <a class="btn" href="index.php?controller=produto&action=index&id=<?= (int)$p['id_jogo'] ?>">Editar</a>
                        <a class="btn btn-danger" href="index.php?controller=produto&action=deletar&id=<?= (int)$p['id_jogo'] ?>"
                           onclick="return confirm('⚠️ DELETAR permanentemente? Não há volta!')">Excluir</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>