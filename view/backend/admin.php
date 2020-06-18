<?php $title = 'Administration'; ?>
<?php $bodyid = 'admin'; ?>
<?php ob_start(); ?>


<div class="container">
   <div class="card bg-light p-2 mb-4">
        <div class="row">
            <div class="col-sm-8">
                <h1><span class="">Administration</span></h1>
            </div>
            <div class="col-sm-4 mt-2">
                <div class="text-right"><a class="btn btn-success" href="index.php">Retour à la liste des copropriétés</a></div>
            </div>
        </div>
    </div>
<?php if (isset($msg)){ echo '<p>', $msg, '</p>';} ?>
    <p id="message"></p>
    
    <div class="row">
        <div class="col-sm-6">
            <form action="index.php" method="post" class="needs-validation" novalidate>        
                <div class="card bg-light">
                    <div class="card-header">
                        <h5>Administrateur</h5>
                    </div>
                    <div class="card-body p-2">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="name">Nom*&nbsp;:</label>
                                    <input type="text" class="form-control form-control-sm" id="name" pattern=".{4,}" maxlength="12" name="name" value="<?= $user1->name() ?>" required>
                                    <div class="valid-feedback"></div>
                                    <div class="invalid-feedback">Ce champ est obligatoire, il doit comporter au moins 4 caractères</div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="password">Mot de passe*&nbsp;:</label>
                                    <input type="text" class="form-control form-control-sm" id="password" name="password" maxlength="20" value="<?= $user1->password() ?>" required>
                                    <div class="valid-feedback"></div>
                                    <div class="invalid-feedback">Ce champ est obligatoire</div>
                               </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="text-right">
                            <div class="btn-group py-0">
                                <button type="submit" id="submitModifUser1" name="submitModifUser1" class="btn btn-sm btn-primary my-0">Enregistrer</button>
                            </div>
                        </div>
                    </div>
                 </div>
            </form>
        </div>
        <div class="col-sm-6">
            <form action="index.php" method="post" class="needs-validation" novalidate>        
                <div class="card bg-light">
                    <div class="card-header">
                        <h5>Utilisateur</h5>
                    </div>
                    <div class="card-body p-2">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="name">Nom*&nbsp;:</label>
                                    <input type="text" class="form-control form-control-sm" id="name" pattern=".{4,}" maxlength="12" name="name" value="<?= $user2->name() ?>" required>
                                    <div class="valid-feedback"></div>
                                    <div class="invalid-feedback">Ce champ est obligatoire, il doit comporter au moins 4 caractères</div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="password">Mot de passe*&nbsp;:</label>
                                    <input type="text" class="form-control form-control-sm" id="password" name="password" maxlength="20" value="<?= $user2->password() ?>" required>
                                    <div class="valid-feedback"></div>
                                    <div class="invalid-feedback">Ce champ est obligatoire</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="text-right">
                            <div class="btn-group py-0">
                                <button type="submit" id="submitModifUser2" name="submitModifUser2" class="btn btn-sm btn-primary my-0">Enregistrer</button>
                            </div>
                        </div>
                    </div>
                 </div>
            </form>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-sm-6">
            <div class="card bg-light">
                <div class="card-header">
                    <h5>Catégories</h5>
                </div>
                <div class="card-body">
<?php
    $i = 0;
    foreach($categories as $category)
    {
        $nbDocs = $documentManager->countWithCategory($category->id());
?>
                    <form action="index.php" method="post">
                        <input type="hidden" name="id" value="<?= $category->id() ?>">
                        <div class="input-group my-2 input-group-sm">
<?php
     if ($i > 0)
     {
?>
                            <div class="input-group-prepend">
                                <button type="submit" class="btn btn-sm btn-primary" name="moveUpCategory">
                                    <i class="fas fa-arrow-up"></i>
                                </button>
                            </div>
<?php
     }
    else
    {
?>
                            <div class="input-group-prepend">
                                <button class="btn btn-sm btn-primary" disabled style="cursor: default">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                            
<?php                            
    }
?>        
                             <input type="text" class="form-control" readonly value="<?= ucfirst($category->name()) ?> (<?= $nbDocs ?><?= $nbDocs > 1 ? ' documents' : ' document' ?>)">
<?php
         if (count($categories) > 1 && $nbDocs == 0 )
         {
?>             
                             <div class="input-group-append">
                                 <button type="submit" class="btn btn-sm btn-danger" name="deleteCategory">Supprimer</button>
                             </div>
<?php
         }
?>        
                        </div>
                    </form>
<?php  
        $i ++;
    }
?>    
                </div>
                <div class="card-footer">
                     <form action="index.php" method="post" class="needs-validation" novalidate>
                         <div class="input-group input-group-sm">
                             <div class="input-group-prepend">
                                 <span class="input-group-text">Nouvelle catégorie</span>
                             </div>
                             <input type="text" name="name" class="form-control" placeholder="Nom*" pattern=".{4,}" required>
                            <div class="valid-feedback"></div>
                            <div class="invalid-feedback">Ce champ est obligatoire, il doit comporter au moins 4 caractères</div>
                             <div class="input-group-append">
                                 <button type="submit" class="btn btn-sm btn-primary" name="createCategory">Enregistrer</button>
                             </div>
                         </div>
                     </form>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card bg-light">
                <div class="card-header">
                    <h5>Types</h5>
                </div>
                <div class="card-body">
<?php                  
    foreach($types as $type)
    {
        $nbDocs = $documentManager->countWithType($type->id());
?>
                    <form action="index.php" method="post">
                        <div class="input-group my-2 input-group-sm">
                             <input type="text" class="form-control" readonly value="<?= ucfirst($type->name()) ?> (<?= $nbDocs ?><?= $nbDocs > 1 ? ' documents' : ' document' ?>)">
<?php
        if (count($types) > 1 && $nbDocs == 0 && $type->id() != '1')
        {
?>
                             <div class="input-group-append">
                                 <input type="hidden" name="id" value="<?= $type->id() ?>">
                                 <button type="submit" class="btn btn-sm btn-danger" name="deleteType">Supprimer</button>
                             </div>
<?php
        }
?>
                        </div>
                    </form>
<?php                        
    }
?>    
                </div>
                <div class="card-footer">
                     <form action="index.php" method="post" class="needs-validation" novalidate>
                         <div class="input-group input-group-sm">
                             <div class="input-group-prepend">
                                 <span class="input-group-text">Nouveau type</span>
                             </div>
                             <input type="text" name="name" class="form-control" placeholder="Nom*" pattern=".{4,}" required>
                            <div class="valid-feedback"></div>
                            <div class="invalid-feedback">Ce champ est obligatoire, il doit comporter au moins 4 caractères</div>
                             <div class="input-group-append">
                                 <button type="submit" class="btn btn-sm btn-primary" name="createType">Enregistrer</button>
                             </div>
                         </div>
                     </form>
                </div>
            </div>
        </div>
    </div>
</div>

                <p>&nbsp;</p>

<?php
$content = ob_get_clean();
require('template.php');
?>