<?php
class Product
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getProducts()
    {
        $this->db->query(
            "SELECT
                produit.idproduit AS product_id,
                produit.libelle AS product_name,
                produit.prix AS product_price,
                produit.description AS product_description,
                admin.idadmin AS admin_id
            FROM
                produit
            INNER JOIN admin ON produit.admin_idadmin = admin.idadmin
            ORDER  BY produit.idproduit DESC 
            "
        );
        return $results = $this->db->resultSet();
    }

    public function addProduct($data)
    {
        $this->db->query('INSERT INTO produit (libelle, admin_idadmin, description, prix ) VALUES(:product_name, :admin_id, :product_description, :product_price)');
        // Bind values
        $this->db->bind(':product_name', $data['product_name']);
        $this->db->bind(':admin_id', $_SESSION['admin_id']);
        $this->db->bind(':product_description', $data['product_description']);
        $this->db->bind(':product_price', $data['product_price']);
        // Execute
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function updateProduct($data)
    {
        $this->db->query('UPDATE produit SET libelle = :product_name, description = :product_description, prix = :product_price WHERE idproduit = :product_id ');
        // Bind values
        $this->db->bind(':product_id', $data['product_id']);
        $this->db->bind(':product_name', $data['product_name']);
        $this->db->bind(':product_description', $data['product_description']);
        $this->db->bind(':product_price', $data['product_price']);

        // Execute
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getProductById($id)
    {
        $this->db->query(
            "SELECT 
                produit.idproduit AS product_id,
                produit.libelle AS product_name,
                produit.prix AS product_price,
                produit.description AS product_description,
                produit.admin_idadmin AS admin_id 
                FROM produit 
            WHERE idproduit = :product_id
            "
        );
        $this->db->bind(':product_id', $id);

        $row = $this->db->single();
        return $row;
    }

    public function deleteProduct($id)
    {
        $this->db->query('DELETE FROM produit WHERE idproduit = :product_id');
        // Bind values
        $this->db->bind(':product_id', $id);

        // Execute
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
