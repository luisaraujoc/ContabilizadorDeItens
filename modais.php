<!-- Modal Adicionar Categoria -->
<div id="modal-add-categoria" class="modal">
    <div class="modal-background" onclick="fecharModal('modal-add-categoria')"></div>
    <div class="modal-card">
        <header class="modal-card-head">
            <p class="modal-card-title">Nova Categoria</p>
            <button class="delete" onclick="fecharModal('modal-add-categoria')"></button>
        </header>
        <section class="modal-card-body">
            <form method="post" action="?action=add_categoria">
                <div class="field">
                    <label class="label">Código</label>
                    <div class="control">
                        <input class="input" type="text" name="codigo" placeholder="Ex: ELET" required>
                    </div>
                </div>
                <div class="field">
                    <label class="label">Nome</label>
                    <div class="control">
                        <input class="input" type="text" name="nome" placeholder="Ex: Eletrônicos" required>
                    </div>
                </div>
                <div class="field">
                    <div class="control">
                        <button type="submit" class="button is-primary">Salvar</button>
                    </div>
                </div>
            </form>
        </section>
    </div>
</div>

<!-- Modal Editar Categoria -->
<div id="modal-edit-categoria" class="modal">
    <div class="modal-background" onclick="fecharModal('modal-edit-categoria')"></div>
    <div class="modal-card">
        <header class="modal-card-head">
            <p class="modal-card-title">Editar Categoria</p>
            <button class="delete" onclick="fecharModal('modal-edit-categoria')"></button>
        </header>
        <section class="modal-card-body">
            <form method="post" action="?action=edit_categoria">
                <input type="hidden" id="edit-categoria-id" name="id">
                <div class="field">
                    <label class="label">Código</label>
                    <div class="control">
                        <input class="input" type="text" id="edit-categoria-codigo" name="codigo" required>
                    </div>
                </div>
                <div class="field">
                    <label class="label">Nome</label>
                    <div class="control">
                        <input class="input" type="text" id="edit-categoria-nome" name="nome" required>
                    </div>
                </div>
                <div class="field">
                    <div class="control">
                        <button type="submit" class="button is-primary">Salvar</button>
                    </div>
                </div>
            </form>
        </section>
    </div>
</div>

<!-- Modal Adicionar Item -->
<div id="modal-add-item" class="modal">
    <div class="modal-background" onclick="fecharModal('modal-add-item')"></div>
    <div class="modal-card">
        <header class="modal-card-head">
            <p class="modal-card-title">Novo Item</p>
            <button class="delete" onclick="fecharModal('modal-add-item')"></button>
        </header>
        <section class="modal-card-body">
            <form method="post" action="?action=add_item">
                <div class="field">
                    <label class="label">Nome</label>
                    <div class="control">
                        <input class="input" type="text" name="nome" placeholder="Ex: Teclado USB" required>
                    </div>
                </div>
                <div class="field">
                    <label class="label">Categoria</label>
                    <div class="control">
                        <div class="select is-fullwidth">
                            <select name="codCategoria" required>
                                <option value="">-- Selecione --</option>
                                <?php foreach ($categorias as $categoria): ?>
                                <option value="<?= $categoria['CodCategoria'] ?>">
                                    <?= $categoria['CodCategoria'] ?> - <?= $categoria['Nome'] ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="field">
                    <label class="label">Quantidade</label>
                    <div class="control">
                        <input class="input" type="number" name="quantidade" min="0" required>
                    </div>
                </div>
                <div class="field">
                    <label class="label">Valor</label>
                    <div class="control">
                        <input class="input" type="number" step="0.01" name="valor" min="0" required>
                    </div>
                </div>
                <div class="field">
                    <div class="control">
                        <button type="submit" class="button is-primary">Salvar</button>
                    </div>
                </div>
            </form>
        </section>
    </div>
</div>

<!-- Modal Editar Item -->
<div id="modal-edit-item" class="modal">
    <div class="modal-background" onclick="fecharModal('modal-edit-item')"></div>
    <div class="modal-card">
        <header class="modal-card-head">
            <p class="modal-card-title">Editar Item</p>
            <button class="delete" onclick="fecharModal('modal-edit-item')"></button>
        </header>
        <section class="modal-card-body">
            <form method="post" action="?action=edit_item">
                <input type="hidden" id="edit-item-id" name="id">
                <div class="field">
                    <label class="label">Nome</label>
                    <div class="control">
                        <input class="input" type="text" id="edit-item-nome" name="nome" required>
                    </div>
                </div>
                <div class="field">
                    <label class="label">Categoria</label>
                    <div class="control">
                        <div class="select is-fullwidth">
                            <select id="edit-item-codCategoria" name="codCategoria" required>
                                <option value="">-- Selecione --</option>
                                <?php foreach ($categorias as $categoria): ?>
                                <option value="<?= $categoria['CodCategoria'] ?>">
                                    <?= $categoria['CodCategoria'] ?> - <?= $categoria['Nome'] ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="field">
                    <label class="label">Quantidade</label>
                    <div class="control">
                        <input class="input" type="number" id="edit-item-quantidade" name="quantidade" min="0" required>
                    </div>
                </div>
                <div class="field">
                    <label class="label">Valor</label>
                    <div class="control">
                        <input class="input" type="number" step="0.01" id="edit-item-valor" name="valor" min="0" required>
                    </div>
                </div>
                <div class="field">
                    <div class="control">
                        <button type="submit" class="button is-primary">Salvar</button>
                    </div>
                </div>
            </form>
        </section>
    </div>
</div>