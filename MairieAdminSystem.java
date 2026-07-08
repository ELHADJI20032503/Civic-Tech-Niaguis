import java.io.PrintStream;
import java.io.UnsupportedEncodingException;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.Scanner;
import java.util.UUID;

public class MairieAdminSystem {
    private static final String URL = "jdbc:mysql://127.0.0.1:3306/civic_tech_niaguis?useSSL=false&allowPublicKeyRetrieval=true&serverTimezone=UTC";
    private static final String USER = "root";
    private static final String PASSWORD = ""; 

    public static void main(String[] args) {
        // Correction des caractères accentués dans la console Windows
        try {
            System.setOut(new PrintStream(System.out, true, "UTF-8"));
        } catch (UnsupportedEncodingException e) {
            // Fallback si l'encodage échoue
        }

        Scanner scanner = new Scanner(System.in, "UTF-8");
        System.out.println("==================================================");
        System.out.println("🛡️ CIVIC-TECH NIAGUIS — MODULE CLIENT LOURD JAVA ");
        System.out.println("==================================================");

        try (Connection connection = DriverManager.getConnection(URL, USER, PASSWORD)) {
            System.out.println("🟢 Connexion JDBC établie avec succès à MySQL.\n");
            boolean quitter = false;

            while (!quitter) {
                System.out.println("\n--- MENU DE SUPERVISION PRIVILÉGIÉ ---");
                System.out.println("1. Afficher le volume global des registres d'état civil");
                System.out.println("2. Consulter le registre centralisé des citoyens");
                System.out.println("3. Auditer le solde de la caisse municipale (");
                System.out.println("4. Enregistrer une nouvelle demande d'acte ");
                System.out.println("5. Quitter l'application Java");
                System.out.print("👉 Sélectionnez une option (1-5) : ");

                int choix = scanner.nextInt();
                scanner.nextLine(); // Consommer le retour à la ligne

                switch (choix) {
                    case 1:
                        afficherStatistiques(connection);
                        break;
                    case 2:
                        consulterCitoyens(connection);
                        break;
                    case 3:
                        auditerCaisse(connection);
                        break;
                    case 4:
                        enregistrerDemandeActe(connection, scanner);
                        break;
                    case 5:
                        quitter = true;
                        System.out.println("🚪 Fermeture du module Java. Fin de transmission.");
                        break;
                    default:
                        System.out.println("✕ Option invalide. Veuillez réessayer.");
                }
            }
        } catch (SQLException e) {
            System.err.println("🔴 Erreur critique de connexion ou de pilote JDBC : " + e.getMessage());
        } finally {
            scanner.close();
        }
    }

    private static void afficherStatistiques(Connection conn) throws SQLException {
        String sql = "SELECT COUNT(*) as total, " +
                     "SUM(CASE WHEN type_acte = 'Naissance' THEN 1 ELSE 0 END) as naissances, " +
                     "SUM(CASE WHEN type_acte = 'Mariage' THEN 1 ELSE 0 END) as mariages, " +
                     "SUM(CASE WHEN type_acte = 'Décès' THEN 1 ELSE 0 END) as deces " +
                     "FROM demandes";
                     
        try (PreparedStatement stmt = conn.prepareStatement(sql);
             ResultSet rs = stmt.executeQuery()) {
            if (rs.next()) {
                System.out.println("\n📊 --- RAPPORT VOLUMÉTRIQUE DES ACTES ---");
                System.out.println("• Total Dossiers enregistrés : " + rs.getInt("total"));
                System.out.println("• Actes de Naissance : " + rs.getInt("naissances"));
                System.out.println("• Actes de Mariage : " + rs.getInt("mariages"));
                System.out.println("• Actes de Décès : " + rs.getInt("deces"));
            }
        }
    }

    private static void consulterCitoyens(Connection conn) throws SQLException {
        String sql = "SELECT id_citoyen, prenom, nom, genre FROM citoyens ORDER BY nom ASC";
        try (PreparedStatement stmt = conn.prepareStatement(sql);
             ResultSet rs = stmt.executeQuery()) {
            System.out.println("\n👥 --- REGISTRE DES CITOYENS ENREGISTRÉS ---");
            System.out.printf("%-10s %-20s %-20s %-6s\n", "ID", "PRÉNOM", "NOM", "GENRE");
            System.out.println("------------------------------------------------------------");
            while (rs.next()) {
                System.out.printf("#%-9d %-20s %-20s %-6s\n", 
                    rs.getInt("id_citoyen"), 
                    rs.getString("prenom"), 
                    rs.getString("nom").toUpperCase(), 
                    rs.getString("genre")
                );
            }
        }
    }

    private static void auditerCaisse(Connection conn) throws SQLException {
        String sqlPaiements = "SELECT SUM(montant) as total FROM paiements";
        int totalReel = 0;

        try (PreparedStatement stmt = conn.prepareStatement(sqlPaiements);
             ResultSet rs = stmt.executeQuery()) {
            if (rs.next()) { totalReel = rs.getInt("total"); }
        } catch (SQLException e) {
            totalReel = 0;
        }

        System.out.println("\n💰 --- BILAN DE LA RÉGIE DE RECETTES MUNICIPALE ---");
        System.out.println("• Recettes réelles en caisse (Table paiements) : " + totalReel + " FCFA");
    }

           // 4. LOGIQUE MÉTIER RECTIFIÉE SÉPARANT STRICTEMENT LES TYPES D'ACTES
    private static void enregistrerDemandeActe(Connection conn, Scanner scanner) throws SQLException {
        System.out.println("\n📝 --- NOUVELLE DÉCLARATION D'ACTE (1 à 3) ---");
        System.out.println("Choisissez le type d'acte :");
        System.out.println("1. Naissance");
        System.out.println("2. Mariage");
        System.out.println("3. Décès");
        System.out.print("👉 Votre choix (1-3) : ");
        
        int typeChoix = scanner.nextInt();
        scanner.nextLine(); // Consommer impérativement le retour à la ligne restant

        String typeActe;
        String evenementLabel;
        switch (typeChoix) {
            case 1:
                typeActe = "Naissance";
                evenementLabel = "naissance";
                break;
            case 2:
                typeActe = "Mariage";
                evenementLabel = "mariage";
                break;
            case 3:
                typeActe = "Décès";
                evenementLabel = "décès";
                break;
            default:
                typeActe = "Naissance";
                evenementLabel = "naissance";
                System.out.println("⚠️ Choix invalide. Par défaut, l'acte sera traité comme une Naissance.");
                break;
        }

        System.out.println("\n--- Saisie des informations pour un acte de : " + typeActe + " ---");
        System.out.print("Nom du citoyen concerné : ");
        String nom = scanner.nextLine();
        System.out.print("Prénom du citoyen concerné : ");
        String prenom = scanner.nextLine();
        System.out.print("Genre (M/F) : ");
        String genre = scanner.nextLine();

        System.out.print("Date de " + evenementLabel + " (Format AAAA-MM-JJ, Ex: 2003-05-25) : ");
        String dateEvenement = scanner.nextLine();
        System.out.print("Lieu de " + evenementLabel + " (Ex: Niaguis) : ");
        String lieuEvenement = scanner.nextLine();

        System.out.println("\n--- Récapitulatif avant enregistrement ---");
        System.out.println("Type d'acte : " + typeActe);
        System.out.println("Nom : " + nom);
        System.out.println("Prénom : " + prenom);
        System.out.println("Genre : " + genre);
        System.out.println("Date de " + evenementLabel + " : " + dateEvenement);
        System.out.println("Lieu de " + evenementLabel + " : " + lieuEvenement);
        System.out.print("Confirmez-vous l'enregistrement de cette demande ? (O/N) : ");
        String confirmation = scanner.nextLine().trim().toUpperCase();
        if (!confirmation.equals("O") && !confirmation.equals("OUI")) {
            System.out.println("✋ Enregistrement annulé par l'utilisateur.");
            return;
        }

        // Étape 1 : Insertion du citoyen dans la table 3NF en fonction du type d'acte
        String sqlCitoyen = "INSERT INTO citoyens (prenom, nom, genre, date_naissance, lieu_naissance, date_mariage, lieu_mariage, date_deces, lieu_deces) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        int idCitoyen = -1;

        try (PreparedStatement stmtCitoyen = conn.prepareStatement(sqlCitoyen, PreparedStatement.RETURN_GENERATED_KEYS)) {
            stmtCitoyen.setString(1, prenom);
            stmtCitoyen.setString(2, nom);
            stmtCitoyen.setString(3, genre);

            String dateNaissance = null;
            String lieuNaissance = null;
            String dateMariage = null;
            String lieuMariage = null;
            String dateDeces = null;
            String lieuDeces = null;

            if (typeActe.equals("Naissance")) {
                dateNaissance = dateEvenement;
                lieuNaissance = lieuEvenement;
            } else if (typeActe.equals("Mariage")) {
                dateMariage = dateEvenement;
                lieuMariage = lieuEvenement;
            } else if (typeActe.equals("Décès")) {
                dateDeces = dateEvenement;
                lieuDeces = lieuEvenement;
            }

            stmtCitoyen.setString(4, dateNaissance);
            stmtCitoyen.setString(5, lieuNaissance);
            stmtCitoyen.setString(6, dateMariage);
            stmtCitoyen.setString(7, lieuMariage);
            stmtCitoyen.setString(8, dateDeces);
            stmtCitoyen.setString(9, lieuDeces);
            stmtCitoyen.executeUpdate();

            try (ResultSet generatedKeys = stmtCitoyen.getGeneratedKeys()) {
                if (generatedKeys.next()) {
                    idCitoyen = generatedKeys.getInt(1);
                }
            }
        }

        if (idCitoyen != -1) {
            try (PreparedStatement stmtCitoyenRecup = conn.prepareStatement(
                "SELECT prenom, nom, genre, date_naissance, lieu_naissance, date_mariage, lieu_mariage, date_deces, lieu_deces FROM citoyens WHERE id_citoyen = ?"
            )) {
                stmtCitoyenRecup.setInt(1, idCitoyen);
                try (ResultSet rsCitoyen = stmtCitoyenRecup.executeQuery()) {
                    if (rsCitoyen.next()) {
                        System.out.println("\n📥 Données du citoyen enregistré :");
                        System.out.println("- Nom : " + rsCitoyen.getString("nom"));
                        System.out.println("- Prénom : " + rsCitoyen.getString("prenom"));
                        System.out.println("- Genre : " + rsCitoyen.getString("genre"));
                        if (typeActe.equals("Naissance")) {
                            System.out.println("- Date de naissance : " + rsCitoyen.getString("date_naissance"));
                            System.out.println("- Lieu de naissance : " + rsCitoyen.getString("lieu_naissance"));
                        } else if (typeActe.equals("Mariage")) {
                            System.out.println("- Date de mariage : " + rsCitoyen.getString("date_mariage"));
                            System.out.println("- Lieu de mariage : " + rsCitoyen.getString("lieu_mariage"));
                        } else if (typeActe.equals("Décès")) {
                            System.out.println("- Date de décès : " + rsCitoyen.getString("date_deces"));
                            System.out.println("- Lieu de décès : " + rsCitoyen.getString("lieu_deces"));
                        }
                    }
                }
            }

            // Étape 2 : Création de la demande liée avec le bon type d'acte isolé
            String numeroSuivi = "CIV-" + UUID.randomUUID().toString().substring(0, 8).toUpperCase();
            String sqlDemande = "INSERT INTO demandes (numero_suivi, id_citoyen, type_acte, statut, id_relais, date_creation) VALUES (?, ?, ?, 'Reçu', 1, NOW())";

            try (PreparedStatement stmtDemande = conn.prepareStatement(sqlDemande)) {
                stmtDemande.setString(1, numeroSuivi);
                stmtDemande.setInt(2, idCitoyen);
                stmtDemande.setString(3, typeActe); // Injecte la valeur dynamique (Naissance, Mariage ou Décès)
                stmtDemande.executeUpdate();

                System.out.println("\n🟢 Succès ! Acte enregistré en base avec succès.");
                System.out.println("📌 Acte traité : " + typeActe);
                System.out.println("📌 Numéro de suivi généré : " + numeroSuivi);
            }
        } else {
            System.out.println("🔴 Erreur lors de la création du profil citoyen.");
        }
    }

}
