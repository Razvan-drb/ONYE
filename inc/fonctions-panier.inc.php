<?php

/**
 * Verifie si le panier existe, le créer sinon
 * @return booleen
 */
function creationPanier(){
   if (!isset($_SESSION['panier'])){
      $_SESSION['panier']=array();
      $_SESSION['panier']['product_name'] = array();
      $_SESSION['panier']['quantity'] = array();
      $_SESSION['panier']['price'] = array();
      $_SESSION['panier']['verrou'] = false;
   }
   return true;
}


/**
 * Ajoute un article dans le panier
 * @param string $product_name
 * @param int $quantity
 * @param float $price
 * @return void
 */
function ajouterArticle($product_name,$quantity,$price){

   //Si le panier existe
   if (creationPanier() && !isVerrouille())
   {
      //Si le produit existe déjà on ajoute seulement la quantité
      $positionProduit = array_search($product_name,  $_SESSION['panier']['product_name']);

      if ($positionProduit !== false)
      {
         $_SESSION['panier']['quantity'][$positionProduit] += $quantity ;
      }
      else
      {
         //Sinon on ajoute le produit
         array_push( $_SESSION['panier']['product_name'],$product_name);
         array_push( $_SESSION['panier']['quantity'],$quantity);
         array_push( $_SESSION['panier']['price'],$price);
      }
   }
   else
   echo "Un problème est survenu veuillez contacter l'administrateur du site.";
}



/**
 * Modifie la quantité d'un article
 * @param $product_name
 * @param $quantity
 * @return void
 */
function modifierQTeArticle($product_name,$quantity){
   //Si le panier existe
   if (creationPanier() && !isVerrouille())
   {
      //Si la quantité est positive on modifie sinon on supprime l'article
      if ($quantity > 0)
      {
         //Recherche du produit dans le panier
         $positionProduit = array_search($product_name,  $_SESSION['panier']['product_name']);

         if ($positionProduit !== false)
         {
            $_SESSION['panier']['quantity'][$positionProduit] = $quantity ;
         }
      }
      else
      supprimerArticle($product_name);
   }
   else
   echo "Un problème est survenu veuillez contacter l'administrateur du site.";
}

/**
 * Supprime un article du panier
 * @param $product_name
 * @return unknown_type
 */
function supprimerArticle($product_name){
   //Si le panier existe
   if (creationPanier() && !isVerrouille())
   {
      //Nous allons passer par un panier temporaire
      $tmp=array();
      $tmp['product_name'] = array();
      $tmp['quantity'] = array();
      $tmp['price'] = array();
      $tmp['verrou'] = $_SESSION['panier']['verrou'];

      for($i = 0; $i < count($_SESSION['panier']['product_name']); $i++)
      {
         if ($_SESSION['panier']['product_name'][$i] !== $product_name)
         {
            array_push( $tmp['product_name'],$_SESSION['panier']['product_name'][$i]);
            array_push( $tmp['quantity'],$_SESSION['panier']['quantity'][$i]);
            array_push( $tmp['price'],$_SESSION['panier']['price'][$i]);
         }

      }
      //On remplace le panier en session par notre panier temporaire à jour
      $_SESSION['panier'] =  $tmp;
      //On efface notre panier temporaire
      unset($tmp);
   }
   else
   echo "Un problème est survenu veuillez contacter l'administrateur du site.";
}


/**
 * Montant total du panier
 * @return int
 */
function MontantGlobal(){
   $total=0;
   for($i = 0; $i < count($_SESSION['panier']['product_name']); $i++)
   {
      $total += $_SESSION['panier']['quantity'][$i] * $_SESSION['panier']['price'][$i];
   }
   return $total;
}


/**
 * Fonction de suppression du panier
 * @return void
 */
function supprimePanier(){
   unset($_SESSION['panier']);
}

/**
 * Permet de savoir si le panier est verrouillé
 * @return booleen
 */
function isVerrouille(){
   if (isset($_SESSION['panier']) && $_SESSION['panier']['verrou'])
   return true;
   else
   return false;
}

/**
 * Compte le nombre d'articles différents dans le panier
 * @return int
 */
function compterArticles()
{
   if (isset($_SESSION['panier']))
   return count($_SESSION['panier']['product_name']);
   else
   return 0;

}
