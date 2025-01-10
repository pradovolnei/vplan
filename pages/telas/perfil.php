<div class="content-header">
    <div class="container">
        <div class="wrapper">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">
                        <!-- general form elements -->
                        <div class="card card-primary">
                            <div class="card-header">
                            <h3 class="card-title">Dados do Usuário</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Nome</label>
                                            <input type="text" class="form-control" id="exampleInputEmail1" required placeholder="Nome" value="<?=$_SESSION["name"]?>">
                                            </div>
                                            <div class="form-group">
                                            <label for="exampleInputPassword1">CPF</label>
                                            <input type="text" class="form-control" id="exampleInputPassword1" required placeholder="CPF" value="<?=$_SESSION["cpf"]?>">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">E-mail</label>
                                            <input type="email" class="form-control" id="exampleInputEmail1" placeholder="E-mail" readonly value="<?=$_SESSION["email"]?>">
                                            </div>
                                            <div class="form-group">
                                            <label for="exampleInputPassword1">Nível</label>
                                            <input type="text" class="form-control" readonly id="exampleInputPassword1" placeholder="CPF" value="<?=getNivel($_SESSION["type"])?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Salvar</button>
                            </div>
                            </form>
                        </div>
                        <!-- /.card -->


                    </div>
                </div>

                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">
                        <!-- general form elements -->
                        <div class="card card-success">
                            <div class="card-header">
                            <h3 class="card-title">Dados do Plano</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Status </label>
                                            <input type="text" readonly class="form-control" id="exampleInputEmail1" placeholder="Nome" value="<?=getStatus($_SESSION["status"])?>">
                                        </div>
                                        
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Período</label> <br>
                                            <?=getExp($_SESSION["expiration"])?>
                                        </div>
                                    </div>
                                </div>

                                
                            </div>

                            <div class="card-body">
                                <div class="row"  >
                                    <div class="col-md-6">
                                        <h3> Usuários </h3>
                                    </div>
                                </div>

                                <div class="row" style="margin-top: 16px;" >
                                    <div class="col-md-3">
                                        <label> Usuários </label>
                                    </div>

                                    <div class="col-md-3">
                                        <a class="btn btn-primary" href=""> Bloquear </a>
                                    </div>
                                </div>
                                
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Salvar</button>
                            </div>
                            </form>
                        </div>
                        <!-- /.card -->


                    </div>
                </div>
            <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        </div>
    </div>
</div>