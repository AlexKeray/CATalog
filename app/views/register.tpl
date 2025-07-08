{extends file='common/layout.tpl'}

{block name="content"}

<!-- register.tpl (по същия стил) -->
    <div class="d-flex justify-content-center pt-5 bg-dark min-vh-100">
        <div class="text-center text-white w-100" style="max-width: 400px;">
            <h2 class="mb-4 fw-bold">Създай акаунт</h2>

            <div class="mb-4">
                <div class="bg-primary rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                    <i class="bi bi-person-plus fs-2 text-white"></i>
                </div>
            </div>

            <form action="register.php" method="post">
                <div class="mb-3">
                    <input type="text" name="username" class="form-control rounded-pill py-2 px-3" placeholder="Потребителско име" required>
                </div>
                <div class="mb-3">
                    <input type="password" name="password" class="form-control rounded-pill py-2 px-3" placeholder="Парола" required>
                </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-primary rounded-pill w-100 py-2">Регистрация</button>
                </div>
            </form>
        </div>
    </div>

{/block}