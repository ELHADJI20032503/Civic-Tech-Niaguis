


package application;
import java.sql.Connection;import java.sql.DriverManager;import java.sql.PreparedStatement;import java.sql.ResultSet;import java.sql.SQLException;import java.util.Scanner;
public class MairieAdminSystem {
    private static final String URL = "jdbc:mysql://127.0.0.1:3306/civic_tech_niaguis?useSSL=false&serverTimezone=UTC&allowPublicKeyRetrieval=true";
    private static final String USER = "root";
    private static final String PASSWORD = ""; 

    public static void main(String[] args) {
        System.out.println("====== PLAN DE CONTINUITE D'ACTIVITE (PCA JAVA 8) ======");
        System.out.println("🔄 Initialisation de la liaison de secours locale...");
        
        try (Connection conn = DriverManager.getConnection(URL, USER, PASSWORD)) {
            System.out.println("🟢 Connexion JDBC etablie avec succes avec la base de donnees !");
            Scanner scanner = new Scanner(System.in);
            
            System.out.print("👤 Saisir identifiant Agent : ");
            String login = scanner.nextLine();
            
            String queryUser = "SELECT * FROM utilisateurs WHERE login = ?";
            try (PreparedStatement pstmt = conn.prepareStatement(queryUser)) {
                pstmt.setString(1, login);
                try (ResultSet rs = pstmt.executeQuery()) {
                    if (rs.next()) {
                        int idRelais = rs.getInt("id_user");
                        String nomComplet = rs.getString("prenom") + " " + rs.getString("nom");
                        String role = rs.getString("role");
                        System.out.println("✅ Authentification reussie ! Bienvenue " + nomComplet + " [" + role + "]");
                        
                        // MENU INTERACTIF DE SÉLECTION D'ACTES
                        System.out.println("\n--- SELECTIONNEZ L'ACTE À ENREGISTRER ---");
                        System.out.println("1. 👶 Declaration de Naissance de Secours");
                        System.out.println("2. 🤵👰 Declaration de Mariage de Secours");
                        System.out.println("3. 🪦 Declaration de Décès de Secours");
                        System.out.print("👉 Votre choix (1-3) : ");
                        int choix = Integer.parseInt(scanner.nextLine());

                        switch (choix) {
                            case 1:
                                gererNaissance(conn, scanner, idRelais);
                                break;
                            case 2:
                                gererMariage(conn, scanner, idRelais);
                                break;
                            case 3:
                                gererDeces(conn, scanner, idRelais);
                                break;
                            default:
                                System.out.println("❌ Choix invalide. Arret du programme.");
                        }
                    } else {
                        System.out.println("❌ Erreur : Identifiant de l'agent municipal introuvable.");
                    }
                }
            }
        } catch (SQLException e) {
            System.err.println("🔴 Erreur critique SQL : " + e.getMessage());
        } catch (Exception e) {
            System.err.println("🔴 Erreur systeme : " + e.getMessage());
        }
    }

    // =========================================================================
    // 👶 1. LOGIQUE COMPLÈTE NAISSANCE
    // =========================================================================
    private static void gererNaissance(Connection conn, Scanner scanner, int idRelais) throws SQLException {
        System.out.println("\n--- [SAISIE COMPLETE - NAISSANCE] ---");
        System.out.print("Prenom de l'enfant : "); String prenom = scanner.nextLine();
        System.out.print("Nom de l'enfant : "); String nom = scanner.nextLine();
        System.out.print("Genre (M/F) : "); String genre = scanner.nextLine();
        System.out.print("Date de naissance (AAAA-MM-JJ) : "); String dateNais = scanner.nextLine();
        System.out.print("Village de naissance (Niaguis) : "); String lieuNais = scanner.nextLine();
        System.out.print("Prenom du Père : "); String prenomPere = scanner.nextLine();
        System.out.print("Prenom de la Mère : "); String prenomMere = scanner.nextLine();
        System.out.print("Nom de la Mère : "); String nomMere = scanner.nextLine();

        conn.setAutoCommit(false);
        try {
            int idCitoyen = insererCitoyen(conn, prenom, nom, dateNais, lieuNais, genre);
            int idDemande = insererDemande(conn, "ACT-", "Naissance", idCitoyen, idRelais);

            String sqlDetails = "INSERT INTO details_naissances (id_demande, prenom_pere, nom_pere, prenom_mere, nom_mere, village_origine) VALUES (?, ?, ?, ?, ?, ?)";
            try (PreparedStatement pstmt = conn.prepareStatement(sqlDetails)) {
                pstmt.setInt(1, idDemande);
                pstmt.setString(2, prenomPere);
                pstmt.setString(3, nom);
                pstmt.setString(4, prenomMere);
                pstmt.setString(5, nomMere);
                pstmt.setString(6, lieuNais);
                pstmt.executeUpdate();
            }
            conn.commit();
            System.out.println("💾 Naissance enregistree et repliquee avec succes !");
        } catch (SQLException e) {
            conn.rollback();
            throw e;
        } finally { conn.setAutoCommit(true); }
    }

    // =========================================================================
    // 🤵👰 2. LOGIQUE COMPLÈTE MARIAGE
    // =========================================================================
    private static void gererMariage(Connection conn, Scanner scanner, int idRelais) throws SQLException {
        System.out.println("\n--- [SAISIE COMPLETE - MARIAGE] ---");
        System.out.print("Prenom de l'Epoux : "); String prenomEpoux = scanner.nextLine();
        System.out.print("Nom de l'Epoux : "); String nomEpoux = scanner.nextLine();
        System.out.print("Prenom de l'Epouse : "); String prenomEpouse = scanner.nextLine();
        System.out.print("Nom de l'Epouse : "); String nomEpouse = scanner.nextLine();
        System.out.print("Date du Mariage (AAAA-MM-JJ) : "); String dateMariage = scanner.nextLine();
        System.out.print("Regime Matrimonial / Coutume : "); String coutume = scanner.nextLine();
        System.out.print("Identite des Temoins : "); String témoins = scanner.nextLine();

        conn.setAutoCommit(false);
        try {
            int idEpoux = insererCitoyen(conn, prenomEpoux, nomEpoux, dateMariage, "Niaguis", "M");
            int idEpouse = insererCitoyen(conn, prenomEpouse, nomEpouse, dateMariage, "Niaguis", "F");
            int idDemande = insererDemande(conn, "MAR-", "Mariage", idEpoux, idRelais);

            String sqlDetails = "INSERT INTO details_mariages (id_demande, id_conjoint_1, id_conjoint_2, coutume_mariage, identite_temoins) VALUES (?, ?, ?, ?, ?)";
            try (PreparedStatement pstmt = conn.prepareStatement(sqlDetails)) {
                pstmt.setInt(1, idDemande);
                pstmt.setInt(2, idEpoux);
                pstmt.setInt(3, idEpouse);
                pstmt.setString(4, coutume);
                pstmt.setString(5, témoins);
                pstmt.executeUpdate();
            }
            conn.commit();
            System.out.println("💾 Mariage enregistree et repliquee avec succes !");
        } catch (SQLException e) {
            conn.rollback();
            throw e;
        } finally { conn.setAutoCommit(true); }
    }

    // =========================================================================
    // 🪦 3. LOGIQUE COMPLÈTE DÉCÈS
    // =========================================================================
    private static void gererDeces(Connection conn, Scanner scanner, int idRelais) throws SQLException {
        System.out.println("\n--- [SAISIE COMPLETE - DECES] ---");
        System.out.print("Prenom du Défunt : "); String prenom = scanner.nextLine();
        System.out.print("Nom du Défunt : "); String nom = scanner.nextLine();
        System.out.print("Date du Deces (AAAA-MM-JJ) : "); String dateDeces = scanner.nextLine();
        System.out.print("Lieu du Deces (Village/Hôpital) : "); String lieuDeces = scanner.nextLine();
        System.out.print("Identite complete du Declarant : "); String declarant = scanner.nextLine();

        conn.setAutoCommit(false);
        try {
            int idCitoyen = insererCitoyen(conn, prenom, nom, dateDeces, lieuDeces, "M");
            int idDemande = insererDemande(conn, "DEC-", "Deces", idCitoyen, idRelais);

            String sqlDetails = "INSERT INTO details_deces (id_demande, date_deces, lieu_deces, identite_declarant) VALUES (?, ?, ?, ?)";
            try (PreparedStatement pstmt = conn.prepareStatement(sqlDetails)) {
                pstmt.setInt(1, idDemande);
                pstmt.setString(2, dateDeces);
                pstmt.setString(3, lieuDeces);
                pstmt.setString(4, declarant);
                pstmt.executeUpdate();
            }
            conn.commit();
            System.out.println("💾 Deces enregistre et repliquee avec succes !");
        } catch (SQLException e) {
            conn.rollback();
            throw e;
        } finally { conn.setAutoCommit(true); }
    }

    // UTILS INSERTS CORE 3NF
    private static int insererCitoyen(Connection conn, String p, String n, String d, String l, String g) throws SQLException {
        String sql = "INSERT INTO citoyens (prenom, nom, date_naissance, lieu_naissance, genre) VALUES (?, ?, ?, ?, ?)";
        try (PreparedStatement pstmt = conn.prepareStatement(sql, PreparedStatement.RETURN_GENERATED_KEYS)) {
            pstmt.setString(1, p); pstmt.setString(2, n); pstmt.setString(3, d); pstmt.setString(4, l); pstmt.setString(5, g);
            pstmt.executeUpdate();

try (ResultSet keys = pstmt.getGeneratedKeys()) {
if (keys.next()) return keys.getInt(1);
}
}
return 0;
}
private static int insererDemande(Connection conn, String prefixe, String type, int idCitoyen, int idRelais) throws SQLException {
String sql = "INSERT INTO demandes (numero_suivi, type_acte, id_citoyen, id_relais, statut) VALUES (?, ?, ?, ?, 'Reçu')";
String numSuivi = prefixe + (int)(Math.random() * 90000 + 10000);
try (PreparedStatement pstmt = conn.prepareStatement(sql, PreparedStatement.RETURN_GENERATED_KEYS)) {
pstmt.setString(1, numSuivi); pstmt.setString(2, type); pstmt.setInt(3, idCitoyen); pstmt.setInt(4, idRelais);
pstmt.executeUpdate();
try (ResultSet keys = pstmt.getGeneratedKeys()) {
if (keys.next()) return keys.getInt(1);
}
}
return 0;
}
}



