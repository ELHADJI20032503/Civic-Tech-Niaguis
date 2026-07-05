import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.Scanner;

public class MairieAdminSystem {
    // Configuration de la connexion JDBC vers ta base MySQL locale
    private static final String URL = "jdbc:mysql://127.0.0.1:3306/civic_tech_niaguis?useSSL=false&allowPublicKeyRetrieval=true&serverTimezone=UTC";
    private static final String USER = "root";
    private static final String PASSWORD = ""; // Par défaut sur XAMPP

    public static void main(String[] args) {
        Scanner scanner = new Scanner(System.in);
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
                System.out.println("3. Auditer le solde de la caisse municipale (Régie)");
                System.out.println("4. Quitter l'application Java");
    
                System.out.print("👉 Sélectionnez une option (1-4) : ");


                int choix = scanner.nextInt();
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

    // 1. REQUÊTE D'AGRÉGATION SUR LES REGISTRES
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

    // 2. EXTRACTION DU REGISTRE DES CITOYENS (CONFORMITÉ 3NF)
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

    // 3. AUDIT DU FINANCEMENT DE LA RÉGIE DE RECETTES
    private static void auditerCaisse(Connection conn) throws SQLException {
        String sqlPaiements = "SELECT SUM(montant) as total FROM paiements";
        String sqlDemandes = "SELECT COUNT(*) * 1000 as total_estime FROM demandes WHERE statut = 'Signé & Archivé'";
        
        int totalReel = 0;
        int totalEstime = 0;

        try (PreparedStatement stmt = conn.prepareStatement(sqlPaiements);
             ResultSet rs = stmt.executeQuery()) {
            if (rs.next()) { totalReel = rs.getInt("total"); }
        } catch (SQLException e) {
            // Sécurité si la table paiements n'est pas encore créée physiquement
            totalReel = 0;
        }

        try (PreparedStatement stmt = conn.prepareStatement(sqlDemandes);
             ResultSet rs = stmt.executeQuery()) {
            if (rs.next()) { totalEstime = rs.getInt("total_estime"); }
        }

        System.out.println("\n💰 --- BILAN DE LA RÉGIE DE RECETTES MUNICIPALE ---");
        System.out.println("• Recettes réelles en caisse (Table paiements)  : " + totalReel + " FCFA");
        System.out.println("• Recettes estimées sur dossiers soldés       : " + totalEstime + " FCFA");
        
        if (totalReel == totalEstime) {
            System.out.println("🟢 Statut Comptable : ÉQUILIBRÉ (Aucun écart détecté).");
        } else {
            System.out.println("⚠️ Attention : Écart de caisse temporaire détecté.");
        }
    }
}
