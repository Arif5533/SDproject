# README – How to Run the Code

This project has two parts:
1) Classification on 4 numeric datasets
2) Spam email detection

Both parts are written to run in Google Colab and use Google Drive for data and outputs.

--------------------------------------------------
1. Classification (4 Datasets)
--------------------------------------------------

1) Open Google Colab
   - Go to: https://colab.research.google.com
   - Open a new notebook.

2) Mount Google Drive
   - In the first cell, run:

     from google.colab import drive
     drive.mount('/content/drive')

   - Follow the link, choose your Google account, paste the auth code.

3) Prepare files in Google Drive
   - In your Drive, create the folder:
     MyDrive/classification/

   - Put these files into that folder:
     - TrainData1.txt, TrainLabel1.txt, TestData1.txt
     - TrainData2.txt, TrainLabel2.txt, TestData2.txt
     - TrainData3.txt, TrainLabel3.txt, TestData3.txt
     - TrainData4.txt, TrainLabel4.txt, TestData4.txt

4) Paste the classification code
   - In a new cell (below the drive.mount cell), paste the full classification code:

     from google.colab import drive
     drive.mount('/content/drive')

     DATA1_TRAIN_X = '/content/drive/MyDrive/classification/TrainData1.txt'
     DATA1_TRAIN_Y = '/content/drive/MyDrive/classification/TrainLabel1.txt'
     DATA1_TEST_X  = '/content/drive/MyDrive/classification/TestData1.txt'
     OUT1          = '/content/drive/MyDrive/classification/HossenClassification1.txt'

     DATA2_TRAIN_X = '/content/drive/MyDrive/classification/TrainData2.txt'
     DATA2_TRAIN_Y = '/content/drive/MyDrive/classification/TrainLabel2.txt'
     DATA2_TEST_X  = '/content/drive/MyDrive/classification/TestData2.txt'
     OUT2          = '/content/drive/MyDrive/classification/HossenClassification2.txt'

     DATA3_TRAIN_X = '/content/drive/MyDrive/classification/TrainData3.txt'
     DATA3_TRAIN_Y = '/content/drive/MyDrive/classification/TrainLabel3.txt'
     DATA3_TEST_X  = '/content/drive/MyDrive/classification/TestData3.txt'
     OUT3          = '/content/drive/MyDrive/classification/HossenClassification3.txt'

     DATA4_TRAIN_X = '/content/drive/MyDrive/classification/TrainData4.txt'
     DATA4_TRAIN_Y = '/content/drive/MyDrive/classification/TrainLabel4.txt'
     DATA4_TEST_X  = '/content/drive/MyDrive/classification/TestData4.txt'
     OUT4          = '/content/drive/MyDrive/classification/HossenClassification4.txt'

     import numpy as np
     from pathlib import Path
     from sklearn.impute import SimpleImputer
     from sklearn.preprocessing import StandardScaler, LabelEncoder
     from sklearn.decomposition import PCA
     from sklearn.svm import SVC
     from sklearn.ensemble import RandomForestClassifier

     def shp(path):
         arr = np.loadtxt(path)
         if arr.ndim == 1:
             arr = arr.reshape(1, -1)
         return arr.shape

     def count_lines(path):
         p = Path(path)
         if not p.exists():
             return 0
         with open(path) as f:
             return sum(1 for _ in f)

     print("D1 TrainX:", shp(DATA1_TRAIN_X), "TrainY:", count_lines(DATA1_TRAIN_Y), "TestX:", shp(DATA1_TEST_X), "Preds:", count_lines(OUT1))
     print("D2 TrainX:", shp(DATA2_TRAIN_X), "TrainY:", count_lines(DATA2_TRAIN_Y), "TestX:", shp(DATA2_TEST_X), "Preds:", count_lines(OUT2))
     print("D3 TrainX:", shp(DATA3_TRAIN_X), "TrainY:", count_lines(DATA3_TRAIN_Y), "TestX:", shp(DATA3_TEST_X), "Preds:", count_lines(OUT3))
     print("D4 TrainX:", shp(DATA4_TRAIN_X), "TrainY:", count_lines(DATA4_TRAIN_Y), "TestX:", shp(DATA4_TEST_X), "Preds:", count_lines(OUT4))

     def load_txt(path):
         p = Path(path)
         if not p.exists():
             print(f"[MISSING] {p}")
             return None
         arr = np.loadtxt(p)
         if arr.ndim == 0:
             arr = np.array([arr])
         if arr.ndim == 1:
             arr = arr.reshape(-1, 1)
         return arr

     def preprocess_fill_scale(X_train, X_test):
         def mark_missing(A):
             A = np.array(A, dtype=float, copy=True)
             A[A == 1e99] = np.nan
             return A

         X_train = mark_missing(X_train)
         X_test  = mark_missing(X_test)

         imp = SimpleImputer(strategy='median')
         X_train = imp.fit_transform(X_train)
         X_test  = imp.transform(X_test)

         sc = StandardScaler()
         X_train = sc.fit_transform(X_train)
         X_test  = sc.transform(X_test)
         return X_train, X_test

     def run_dataset(idx, train_x, train_y, test_x, out_path):
         X_train = load_txt(train_x)
         y_train = load_txt(train_y)
         X_test  = load_txt(test_x)

         if X_train is None or y_train is None or X_test is None:
             print(f"[Set {idx}] Skipped (missing file).")
             return

         y_train_raw = np.ravel(y_train).astype(float)
         y_train_raw = np.round(y_train_raw).astype(int)

         if X_train.shape[1] != X_test.shape[1]:
             raise ValueError(f"[Set {idx}] Feature mismatch: train={X_train.shape[1]}, test={X_test.shape[1]}")

         X_train_p, X_test_p = preprocess_fill_scale(X_train, X_test)

         le = LabelEncoder()
         y_enc = le.fit_transform(y_train_raw)

         if idx in (1, 2) or X_train_p.shape[1] > 1000:
             n_comp = max(1, min(X_train_p.shape[0] - 1, X_train_p.shape[1]))
             pca = PCA(n_components=n_comp, svd_solver='full', random_state=42)
             X_train_p = pca.fit_transform(X_train_p)
             X_test_p  = pca.transform(X_test_p)

             clf = SVC(kernel='rbf', C=3.0, gamma='scale',
                       class_weight='balanced', random_state=42)
             clf.fit(X_train_p, y_enc)
             y_pred_enc = clf.predict(X_test_p)
             model_name = "PCA + SVM(RBF)"
         else:
             clf = RandomForestClassifier(
                 n_estimators=300, random_state=42,
                 class_weight='balanced_subsample', n_jobs=-1
             )
             clf.fit(X_train_p, y_enc)
             y_pred_enc = clf.predict(X_test_p)
             model_name = "RandomForest"

         y_pred = le.inverse_transform(y_pred_enc).astype(int)
         np.savetxt(out_path, y_pred, fmt='%d')

         up = np.unique(y_pred)
         print(f"[Set {idx}] {model_name} -> wrote {len(y_pred)} predictions to {out_path}")
         print(f"          Unique predicted labels: {up}")

     configs = [
         (1, DATA1_TRAIN_X, DATA1_TRAIN_Y, DATA1_TEST_X, OUT1),
         (2, DATA2_TRAIN_X, DATA2_TRAIN_Y, DATA2_TEST_X, OUT2),
         (3, DATA3_TRAIN_X, DATA3_TRAIN_Y, DATA3_TEST_X, OUT3),
         (4, DATA4_TRAIN_X, DATA4_TRAIN_Y, DATA4_TEST_X, OUT4),
     ]

     for c in configs:
         try:
             run_dataset(*c)
         except Exception as e:
             print(f"[Set {c[0]}] Error: {e}")

5) Run the cell.
   - When it finishes, check in Drive:
     MyDrive/classification/
   - You should see:
     HossenClassification1.txt
     HossenClassification2.txt
     HossenClassification3.txt
     HossenClassification4.txt

--------------------------------------------------
2. Spam Email Detection
--------------------------------------------------

1) Open Google Colab
   - Use the same notebook or open a new one.

2) Mount Google Drive
   - If not already mounted in this notebook, run:

     from google.colab import drive
     drive.mount('/content/drive')

3) Prepare files in Google Drive
   - In your Drive, create:
     MyDrive/Spam Email Detection/

   - Put these files inside:
     spam_train1.csv
     spam_train2.csv
     spam_test.csv

4) Paste the spam detection code
   - In a new cell, paste:

     from google.colab import drive
     drive.mount('/content/drive')

     TRAIN1 = '/content/drive/MyDrive/Spam Email Detection/spam_train1.csv'
     TRAIN2 = '/content/drive/MyDrive/Spam Email Detection/spam_train2.csv'
     TEST   = '/content/drive/MyDrive/Spam Email Detection/spam_test.csv'
     OUT    = '/content/drive/MyDrive/Spam Email Detection/HossenSpam.txt'

     import pandas as pd
     import numpy as np
     from pathlib import Path
     import matplotlib.pyplot as plt

     from sklearn.feature_extraction.text import TfidfVectorizer
     from sklearn.naive_bayes import MultinomialNB
     from sklearn.tree import DecisionTreeClassifier
     from sklearn.svm import LinearSVC
     from sklearn.neural_network import MLPClassifier
     from sklearn.pipeline import Pipeline
     from sklearn.model_selection import StratifiedKFold, cross_val_score
     from sklearn.metrics import (
         accuracy_score,
         classification_report,
         confusion_matrix,
         roc_auc_score,
         RocCurveDisplay
     )

     def load_csv(p):
         p = Path(p)
         if not p.exists():
             raise FileNotFoundError(p)
         return pd.read_csv(p)

     def clean_text(s):
         s = s.fillna('').astype(str).str.lower()
         s = s.str.replace(r'<[^>]+>', ' ', regex=True)
         s = s.str.replace(r'http\S+|www\.\S+', ' url ', regex=True)
         s = s.str.replace(r'\d+', ' num ', regex=True)
         s = s.str.replace(r'\s+', ' ', regex=True).str.strip()
         return s

     def detect_text_col(df):
         lower = {c.lower(): c for c in df.columns}
         for k in ['text', 'message', 'email', 'body', 'content', 'subject', 'emailtext']:
             if k in lower:
                 return lower[k]
         obj_cols = [c for c in df.columns if df[c].dtype == 'object']
         if obj_cols:
             return max(obj_cols, key=lambda c: df[c].fillna('').astype(str).str.len().mean())
         return df.columns[0]

     def detect_label_col(df, text_col=None):
         lower = {c.lower(): c for c in df.columns}
         for k in ['label', 'spam', 'is_spam', 'target', 'class', 'category', 'y']:
             if k in lower:
                 return lower[k]
         candidates = []
         for c in df.columns:
             if text_col is not None and c == text_col:
                 continue
             uniq = df[c].nunique(dropna=True)
             if uniq <= 5:
                 candidates.append((uniq, c))
         if candidates:
             candidates.sort(key=lambda x: (x[0], x[1]))
             return candidates[0][1]
         raise ValueError(f"Could not find a label column. Columns: {list(df.columns)}")

     df1 = load_csv(TRAIN1)
     df2 = load_csv(TRAIN2)
     dft = load_csv(TEST)

     t1 = detect_text_col(df1)
     y1 = detect_label_col(df1, t1)
     t2 = detect_text_col(df2)
     y2 = detect_label_col(df2, t2)
     tt = detect_text_col(dft)

     print(f"[train1] text='{t1}', label='{y1}'")
     print(f"[train2] text='{t2}', label='{y2}'")
     print(f"[ test ] text='{tt}'")

     df1[t1] = clean_text(df1[t1])
     df2[t2] = clean_text(df2[t2])
     dft[tt] = clean_text(dft[tt])

     train1 = pd.DataFrame({'text': df1[t1], 'label': df1[y1]})
     train2 = pd.DataFrame({'text': df2[t2], 'label': df2[y2]})
     train = pd.concat([train1, train2], ignore_index=True)

     lab = train['label'].astype(str).str.lower().str.strip()
     lab = lab.replace({
         '1': 'spam',
         '0': 'ham',
         'junk': 'spam',
         'not spam': 'ham',
         'spam': 'spam',
         'ham': 'ham'
     })

     if lab.nunique() > 2:
         maj = lab.value_counts().idxmax()
         lab = lab.apply(lambda x: 'ham' if x == maj else 'spam')

     train['label_norm'] = lab

     X_text = train['text'].values
     y_bin = (train['label_norm'] == 'spam').astype(int).values
     X_test = dft[tt].values

     print("Train size:", len(train), "| class counts:", dict(train['label_norm'].value_counts()))

     cv = StratifiedKFold(n_splits=3, shuffle=True, random_state=42)

     models = {
         "NaiveBayes": MultinomialNB(alpha=0.5),
         "DecisionTree": DecisionTreeClassifier(random_state=42),
         "LinearSVM": LinearSVC(random_state=42),
         "MLP": MLPClassifier(hidden_layer_sizes=(20,), max_iter=50, random_state=42)
     }

     cv_scores = {}

     for name, clf in models.items():
         pipe = Pipeline([
             ('tfidf', TfidfVectorizer(
                 ngram_range=(1, 1),
                 strip_accents='unicode',
                 sublinear_tf=True,
                 stop_words='english'
             )),
             ('clf', clf)
         ])
         scores = cross_val_score(pipe, X_text, y_bin, cv=cv, scoring='f1_macro')
         cv_scores[name] = scores.mean()
         print(f"{name} CV macro-F1: {scores.mean():.3f} ± {scores.std():.3f}")

     plt.figure()
     names = list(cv_scores.keys())
     vals = [cv_scores[k] for k in names]
     plt.bar(names, vals)
     plt.ylim(0, 1)
     plt.ylabel("CV macro-F1")
     plt.title("Model comparison (macro-F1)")
     plt.show()

     alphas = [0.1, 0.5, 1.0]
     best_alpha = None
     best_f1 = -1.0

     for a in alphas:
         pipe_tmp = Pipeline([
             ('tfidf', TfidfVectorizer(
                 ngram_range=(1, 1),
                 strip_accents='unicode',
                 sublinear_tf=True,
                 stop_words='english'
             )),
             ('clf', MultinomialNB(alpha=a))
         ])
         scores = cross_val_score(pipe_tmp, X_text, y_bin, cv=cv, scoring='f1_macro')
         mean_f1 = scores.mean()
         print(f"Tuning alpha={a}, CV macro-F1={mean_f1:.3f}")
         if mean_f1 > best_f1:
             best_f1 = mean_f1
             best_alpha = a

     print("Best alpha for Naive Bayes:", best_alpha)

     final_pipe = Pipeline([
         ('tfidf', TfidfVectorizer(
             ngram_range=(1, 1),
             strip_accents='unicode',
             sublinear_tf=True,
             stop_words='english'
         )),
         ('clf', MultinomialNB(alpha=best_alpha))
     ])

     final_pipe.fit(X_text, y_bin)

     y_train_pred = final_pipe.predict(X_text)
     acc = accuracy_score(y_bin, y_train_pred)
     print(f"Train Accuracy (final model): {acc:.3f}")
     print("Classification report (final model):")
     print(classification_report(y_bin, y_train_pred, target_names=['Ham', 'Spam']))
     print("Confusion matrix (final model):")
     cm = confusion_matrix(y_bin, y_train_pred)
     print(cm)

     plt.figure()
     plt.imshow(cm, cmap='Blues')
     plt.title("Confusion matrix (final model)")
     plt.xlabel("Predicted")
     plt.ylabel("True")
     plt.xticks([0, 1], ["Ham", "Spam"])
     plt.yticks([0, 1], ["Ham", "Spam"])
     for i in range(2):
         for j in range(2):
             plt.text(j, i, cm[i, j], ha="center", va="center")
     plt.colorbar()
     plt.show()

     try:
         proba_tr = final_pipe.predict_proba(X_text)[:, 1]
         auc = roc_auc_score(y_bin, proba_tr)
         print(f"Train ROC-AUC (final model): {auc:.3f}")
     except Exception as e:
         print("ROC-AUC could not be computed for final model.")
         print(e)

     y_pred_test = final_pipe.predict(X_test)

     Path(OUT).parent.mkdir(parents=True, exist_ok=True)
     with open(OUT, 'w', encoding='utf-8') as f:
         for v in y_pred_test:
             f.write(str(int(v)) + '\n')

     print(f"Wrote {len(y_pred_test)} predictions (0=ham, 1=spam) to: {OUT}")
     print("Sample predictions (0/1):", y_pred_test[:10])

     try:
         n_test = len(pd.read_csv(TEST))
         assert len(y_pred_test) == n_test, f"Mismatch: {len(y_pred_test)} preds vs {n_test} test rows"
         print("Prediction count matches test rows.")
     except Exception as e:
         print("Verification note:", e)

5) Run the cell.
   - When it finishes, check in Drive:
     MyDrive/Spam Email Detection/
   - You should see:
     HossenSpam.txt
   - This file has one value per line:
     0 = ham, 1 = spam.
