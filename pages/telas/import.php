<div class="container mt-4">
    <h2>Upload de Planilha</h2>
    <form action="?l=<?=base64_encode(3)?>" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="planilha" class="form-label">Selecione uma planilha:</label>
            <input type="file" class="form-control" id="planilha" name="planilha" accept=".xls,.xlsx" required>
        </div>
        <button type="submit" class="btn btn-primary">Upload</button>
    </form>
</div>
